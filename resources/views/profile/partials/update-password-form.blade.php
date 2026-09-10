<section id="account-security" class="scroll-mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-[#142532]">
    <header class="flex items-start gap-3 border-b border-slate-100 px-5 py-5 sm:px-7 dark:border-slate-700">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-600 dark:bg-teal-900/40 dark:text-teal-300"><x-care-icon name="shield" /></span>
        <div><h2 class="text-base font-bold text-slate-800 dark:text-slate-100">Password & security</h2>
        <p class="mt-1 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Choose a strong password you do not use elsewhere.</p></div>
    </header>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6 p-5 sm:p-7">
        @csrf
        @method('put')
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <x-profile-field id="update_password_current_password" name="current_password" type="password" label="Current password" :messages="$errors->updatePassword->get('current_password')" autocomplete="current-password" placeholder="Enter your current password" />
            </div>
            <x-profile-field id="update_password_password" name="password" type="password" label="New password" :messages="$errors->updatePassword->get('password')" autocomplete="new-password" placeholder="Create a new password" />
            <x-profile-field id="update_password_password_confirmation" name="password_confirmation" type="password" label="Confirm new password" :messages="$errors->updatePassword->get('password_confirmation')" autocomplete="new-password" placeholder="Re-enter your new password" />
        </div>
        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5 dark:border-slate-700">
            <p class="text-xs text-slate-500 dark:text-slate-400">Keep your password private.</p>
            <div class="flex items-center gap-3">
                @if (session('status') === 'password-updated')<p role="status" class="text-sm font-medium text-teal-700 dark:text-teal-300">Password updated.</p>@endif
                <x-profile-save-button>Update password</x-profile-save-button>
            </div>
        </div>
    </form>
</section>
