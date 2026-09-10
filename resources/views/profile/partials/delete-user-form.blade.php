<section id="delete-account" class="scroll-mt-6 rounded-2xl border border-red-200 bg-white p-5 sm:p-7 dark:border-red-900/60 dark:bg-[#142532]">
    <div class="flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-center">
        <div class="max-w-xl">
            <h2 class="text-base font-bold text-red-700 dark:text-red-300">Delete account</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400">Permanently delete your account and its associated data. Save any information you want to keep before continuing.</p>
        </div>
        <button type="button" x-data="" @click="$dispatch('open-modal', 'confirm-user-deletion')" class="shrink-0 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700 hover:bg-red-100 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300 dark:hover:bg-red-900/40">Delete account</button>
    </div>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="bg-white p-6 sm:p-8 dark:bg-[#142532]">
            @csrf
            @method('delete')
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Delete your account?</h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-500 dark:text-slate-400">This action is permanent. Enter your current password to confirm that you want to delete your account and its associated data.</p>
            <div class="mt-6">
                <x-profile-field id="delete_account_password" name="password" type="password" label="Current password" :messages="$errors->userDeletion->get('password')" autocomplete="current-password" placeholder="Enter your password to confirm" />
            </div>
            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <button type="button" @click="$dispatch('close')" class="rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Cancel</button>
                <button type="submit" class="rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700">Delete account</button>
            </div>
        </form>
    </x-modal>
</section>
