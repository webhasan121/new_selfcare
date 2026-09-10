<x-app-layout>
    <x-slot name="header">
        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-teal-700 dark:text-teal-300">Your personal workspace</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-800 dark:text-slate-100">My profile</h1>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Manage your personal details and account security.</p>
    </x-slot>

    <div class="grid items-start gap-6 xl:grid-cols-[280px_minmax(0,1fr)]">
        <aside class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-[#142532]">
            <div class="h-20 bg-gradient-to-br from-teal-700 to-teal-500"></div>
            <div class="px-6 pb-6">
                <div class="-mt-8 flex h-16 w-16 items-center justify-center rounded-2xl border-4 border-white bg-teal-100 text-2xl font-bold text-teal-800 dark:border-[#142532] dark:bg-teal-900 dark:text-teal-200">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <h2 class="mt-4 break-words text-lg font-bold text-slate-800 dark:text-slate-100">{{ $user->name }}</h2>
                <p class="mt-1 break-all text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-teal-50 px-3 py-1 text-xs font-medium text-teal-700 dark:bg-teal-900/40 dark:text-teal-300"><x-care-icon name="user" class="!h-3.5 !w-3.5" /> Personal account</span>
                <nav aria-label="Profile sections" class="mt-6 space-y-1 border-t border-slate-100 pt-5 dark:border-slate-700">
                    <a href="#personal-details" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-600 hover:bg-teal-50 hover:text-teal-700 dark:text-slate-300 dark:hover:bg-teal-900/30 dark:hover:text-teal-300"><x-care-icon name="user" /> Personal details</a>
                    <a href="#account-security" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-slate-600 hover:bg-teal-50 hover:text-teal-700 dark:text-slate-300 dark:hover:bg-teal-900/30 dark:hover:text-teal-300"><x-care-icon name="shield" /> Password & security</a>
                    <a href="#delete-account" class="flex items-center gap-3 rounded-lg px-3 py-3 text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-900/20"><x-care-icon name="logout" /> Delete account</a>
                </nav>
            </div>
        </aside>
        <div class="min-w-0 space-y-6">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
