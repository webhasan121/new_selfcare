<section id="personal-details" class="scroll-mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-[#142532]">
    <header class="flex items-start gap-3 border-b border-slate-100 px-5 py-5 sm:px-7 dark:border-slate-700">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-600 dark:bg-teal-900/40 dark:text-teal-300"><x-care-icon name="user" /></span>
        <div><h2 class="text-base font-bold text-slate-800 dark:text-slate-100">Personal details</h2>
        <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Keep your name and contact email up to date.</p></div>
    </header>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 p-5 sm:p-7">
        @csrf
        @method('patch')
        <div class="grid gap-5 md:grid-cols-2">
            <x-profile-field name="name" label="Full name" :value="old('name', $user->name)" :messages="$errors->get('name')" autocomplete="name" placeholder="Your full name" />
            <x-profile-field name="email" type="email" label="Email address" :value="old('email', $user->email)" :messages="$errors->get('email')" autocomplete="email" placeholder="you@example.com" />
        </div>
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-relaxed text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                <p>Your email address is unverified.</p>
                <button form="send-verification" class="mt-1 font-semibold underline underline-offset-4">Resend verification email</button>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2" role="status">A new verification link has been sent to your email address.</p>
                @endif
            </div>
        @endif
        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5 dark:border-slate-700">
            <p class="text-xs text-slate-500 dark:text-slate-400">Use an email address you can access.</p>
            <div class="flex items-center gap-3">
                @if (session('status') === 'profile-updated')<p role="status" class="text-sm font-medium text-teal-700 dark:text-teal-300">Changes saved.</p>@endif
                <x-profile-save-button>Save changes</x-profile-save-button>
            </div>
        </div>
    </form>
</section>
