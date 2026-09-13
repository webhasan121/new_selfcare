<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(int|string $identifier, mixed $default = null): mixed
    {
        $setting = is_int($identifier)
            ? Setting::query()->find($identifier)
            : Setting::query()->where('name', $identifier)->first();

        return $setting?->value ?? $default;
    }
}
