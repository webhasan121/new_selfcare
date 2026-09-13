<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->apiLoginEnabled()) {
            return [
                'user_id' => ['required', 'integer', 'min:1'],
                'secret' => ['required', 'string'],
            ];
        }

        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $authenticated = $this->apiLoginEnabled()
            ? $this->authenticateWithApiCredentials()
            : Auth::attempt($this->only('email', 'password'), $this->boolean('remember'));

        if (! $authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                $this->apiLoginEnabled() ? 'user_id' : 'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $identifier = $this->apiLoginEnabled()
            ? $this->string('user_id')
            : Str::lower($this->string('email'));

        return Str::transliterate($identifier.'|'.$this->ip());
    }

    private function apiLoginEnabled(): bool
    {
        return (string) setting('Auth Method', '0') === '1';
    }

    private function authenticateWithApiCredentials(): bool
    {
        $user = User::query()->find($this->integer('user_id'));

        if ($user === null || ! Hash::check($this->string('secret'), $user->password)) {
            return false;
        }

        Auth::login($user, $this->boolean('remember'));

        return true;
    }
}
