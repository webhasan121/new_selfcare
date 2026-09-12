<x-app-layout>
    <div class="mx-auto max-w-6xl">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-5">
            <div><div class="text-[9px] font-bold tracking-[1.8px] text-[#6d8991] dark:text-[#8faab9]">ADMINISTRATION</div><h1 class="mt-2 text-[30px] font-bold tracking-[-1px] text-[#183440] dark:text-[#e5f0f4]">Permissions</h1><p class="mt-1 text-[13px] text-[#7d8f97] dark:text-[#9db0bb]">Manage the abilities that can be assigned to roles.</p></div>
            @can('create', \Spatie\Permission\Models\Permission::class)<a href="{{ route('permissions.create') }}" class="rounded-xl bg-[#168f80] px-5 py-3 text-xs font-bold text-white hover:bg-[#11796d] dark:bg-[#20aa96] dark:text-[#071f25] dark:hover:bg-[#55d5bd]">+ Create permission</a>@endcan
        </div>

        @if (session('success'))<div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-[#285e53] dark:bg-[#102f2c] dark:text-[#8be3cf]">{{ session('success') }}</div>@endif
        @if ($errors->has('permission'))<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-[#713d45] dark:bg-[#351d25] dark:text-[#ffabb4]">{{ $errors->first('permission') }}</div>@endif

        <form method="GET" action="{{ route('permissions.index') }}" class="mb-5 flex max-w-sm gap-2"><input name="search" value="{{ $search }}" placeholder="Search permissions" class="min-w-0 flex-1 rounded-xl border-[#d8e2e4] bg-white text-sm focus:border-[#28ae9a] focus:ring-[#28ae9a] dark:border-[#405762] dark:bg-[#132a35] dark:text-[#e5eff2]"><button class="rounded-xl border border-[#d8e2e4] bg-white px-4 text-xs font-bold text-[#397168] dark:border-[#405762] dark:bg-[#132a35] dark:text-[#8addc8]">Search</button></form>

        <section class="overflow-hidden rounded-2xl border border-[#e0e8ea] bg-white shadow-sm dark:border-[#304753] dark:bg-[#132a35]">
            <div class="hidden grid-cols-[minmax(240px,1fr)_100px_100px_170px] gap-4 bg-[#f7f9fa] px-6 py-3 text-[10px] font-bold uppercase tracking-[1.2px] text-[#778b93] md:grid dark:bg-[#10242e] dark:text-[#8fa7b2]"><span>Permission</span><span>Roles</span><span>Users</span><span class="text-right">Actions</span></div>
            <div class="divide-y divide-[#e9eff0] dark:divide-[#2d4550]">
                @forelse ($permissions as $permission)
                    <article class="grid gap-4 px-6 py-5 hover:bg-[#f8fbfa] md:grid-cols-[minmax(240px,1fr)_100px_100px_170px] md:items-center phone:px-4 dark:hover:bg-[#18343e]">
                        <div class="flex min-w-0 items-center gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#e8f6f2] text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]"><x-care-icon name="key" /></span><div class="min-w-0"><p class="truncate font-bold text-[#29444f] dark:text-[#e3eef2]">{{ $permission->name }}</p><p class="mt-1 text-[10px] uppercase tracking-wide text-[#94a2a8]">web guard</p></div></div>
                        <div class="flex justify-between text-xs md:block"><span class="md:hidden">Roles</span><b class="rounded-lg bg-[#f0f4f5] px-2.5 py-1.5 dark:bg-[#203945]">{{ $permission->roles_count }}</b></div>
                        <div class="flex justify-between text-xs md:block"><span class="md:hidden">Users</span><b class="rounded-lg bg-[#f0f4f5] px-2.5 py-1.5 dark:bg-[#203945]">{{ $permission->users_count }}</b></div>
                        <div class="flex justify-end gap-2 border-t border-[#edf1f2] pt-4 md:border-0 md:pt-0 dark:border-[#2d4550]">@can('update', $permission)<a href="{{ route('permissions.edit', $permission) }}" class="rounded-lg border border-[#d5e0e2] px-3.5 py-2 text-xs font-semibold text-[#397168] dark:border-[#405966] dark:text-[#8addc8]">Edit</a>@endcan @can('delete', $permission)<form method="POST" action="{{ route('permissions.destroy', $permission) }}" onsubmit="return confirm('Delete this permission?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3.5 py-2 text-xs font-semibold text-red-600 dark:border-[#68404a] dark:text-[#ff9aa7]">Delete</button></form>@endcan</div>
                    </article>
                @empty
                    <div class="px-6 py-16 text-center text-sm text-[#71838b] dark:text-[#91a8b3]">No permissions found.</div>
                @endforelse
            </div>
        </section>
        @if ($permissions->hasPages())<div class="mt-5">{{ $permissions->links() }}</div>@endif
    </div>
</x-app-layout>
