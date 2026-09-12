<x-app-layout>
    <div class="mx-auto max-w-6xl">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-5">
            <div><div class="text-[9px] font-bold tracking-[1.8px] text-[#6d8991] dark:text-[#8faab9]">ADMINISTRATION</div><h1 class="mt-2 text-[30px] font-bold tracking-[-1px] text-[#183440] dark:text-[#e5f0f4]">Users</h1><p class="mt-1 text-[13px] text-[#7d8f97] dark:text-[#9db0bb]">Assign roles to the people in your workspace.</p></div>
            <form method="GET" action="{{ route('users.index') }}" class="flex w-full max-w-sm gap-2">
                <input name="search" value="{{ $search }}" placeholder="Search name, email or contact" class="min-w-0 flex-1 rounded-xl border-[#d8e2e4] bg-white text-sm focus:border-[#28ae9a] focus:ring-[#28ae9a] dark:border-[#405762] dark:bg-[#132a35] dark:text-[#e5eff2] dark:placeholder:text-[#708994]">
                <button class="rounded-xl bg-[#168f80] px-4 text-xs font-bold text-white hover:bg-[#11796d] dark:bg-[#20aa96] dark:text-[#071f25]">Search</button>
            </form>
        </div>

        @if (session('success'))<div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-[#285e53] dark:bg-[#102f2c] dark:text-[#8be3cf]">{{ session('success') }}</div>@endif

        <section class="overflow-hidden rounded-2xl border border-[#e0e8ea] bg-white shadow-[0_10px_35px_#193d4610] dark:border-[#304753] dark:bg-[#132a35] dark:shadow-[0_14px_40px_#0004]">
            <div class="border-b border-[#e9eff0] px-6 py-5 dark:border-[#2d4550]"><h2 class="font-bold text-[#29444f] dark:text-[#e0edf1]">Workspace users</h2><p class="mt-1 text-xs text-[#89999f] dark:text-[#91a8b3]">{{ $users->total() }} {{ Str::plural('user', $users->total()) }} found</p></div>
            <div class="hidden grid-cols-[minmax(250px,1.4fr)_minmax(180px,1fr)_100px] gap-4 bg-[#f7f9fa] px-6 py-3 text-[10px] font-bold uppercase tracking-[1.2px] text-[#778b93] md:grid dark:bg-[#10242e] dark:text-[#8fa7b2]"><span>User</span><span>Roles</span><span class="text-right">Action</span></div>
            <div class="divide-y divide-[#e9eff0] dark:divide-[#2d4550]">
                @forelse ($users as $managedUser)
                    <article class="grid gap-4 px-6 py-5 hover:bg-[#f8fbfa] md:grid-cols-[minmax(250px,1.4fr)_minmax(180px,1fr)_100px] md:items-center phone:px-4 dark:hover:bg-[#18343e]">
                        <div class="flex min-w-0 items-center gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#e8f6f2] font-bold text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]">{{ mb_strtoupper(mb_substr($managedUser->name, 0, 1)) }}</span><div class="min-w-0"><p class="truncate font-bold text-[#29444f] dark:text-[#e3eef2]">{{ $managedUser->name }}</p><p class="mt-1 truncate text-xs text-[#89999f] dark:text-[#91a8b3]">{{ $managedUser->email }}</p></div></div>
                        <div class="flex flex-wrap gap-1.5">@forelse ($managedUser->roles as $role)<span class="rounded-full bg-[#edf5f3] px-2.5 py-1 text-[10px] font-bold capitalize text-[#397168] dark:bg-[#1d423d] dark:text-[#8addc8]">{{ str_replace('_', ' ', $role->name) }}</span>@empty<span class="text-xs text-[#96a5aa] dark:text-[#718b96]">No role assigned</span>@endforelse</div>
                        <div class="flex justify-end">@can('update', $managedUser)<a href="{{ route('users.edit', $managedUser) }}" class="rounded-lg border border-[#d5e0e2] px-3.5 py-2 text-xs font-semibold text-[#397168] hover:bg-[#edf7f4] dark:border-[#405966] dark:bg-[#172f3a] dark:text-[#8addc8] dark:hover:bg-[#20433e]">Manage</a>@endcan</div>
                    </article>
                @empty
                    <div class="px-6 py-16 text-center text-sm text-[#71838b] dark:text-[#91a8b3]">No users matched your search.</div>
                @endforelse
            </div>
        </section>
        @if ($users->hasPages())<div class="mt-5 dark:text-[#b4c5cc]">{{ $users->links() }}</div>@endif
    </div>
</x-app-layout>
