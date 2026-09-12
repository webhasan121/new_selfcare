<x-app-layout>
    <div class="mx-auto max-w-6xl">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-5">
            <div>
                <div class="flex items-center gap-2 text-[9px] font-bold tracking-[1.8px] text-[#6d8991] dark:text-[#8faab9]"><span class="h-1.5 w-1.5 rounded-full bg-[#20bda5]"></span> ADMINISTRATION</div>
                <h1 class="mt-2 text-[30px] font-bold tracking-[-1px] text-[#183440] dark:text-[#e5f0f4]">Roles</h1>
                <p class="mt-1 text-[13px] text-[#7d8f97] dark:text-[#9db0bb]">Control how users are grouped across your workspace.</p>
            </div>
            @can('create', \Spatie\Permission\Models\Role::class)
                <a href="{{ route('roles.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#168f80] px-5 py-3 text-xs font-bold text-white shadow-[0_8px_20px_#168f8028] hover:-translate-y-0.5 hover:bg-[#11796d] dark:bg-[#20aa96] dark:text-[#071f25] dark:shadow-[0_8px_24px_#0005] dark:hover:bg-[#55d5bd]"><span class="text-base leading-none">+</span> Create role</a>
            @endcan
        </div>

        @if (session('success'))
            <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-[#285e53] dark:bg-[#102f2c] dark:text-[#8be3cf]"><span class="grid h-6 w-6 place-items-center rounded-full bg-emerald-100 text-xs dark:bg-[#205046]">✓</span>{{ session('success') }}</div>
        @endif
        @if ($errors->has('role'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-[#713d45] dark:bg-[#351d25] dark:text-[#ffabb4]">{{ $errors->first('role') }}</div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-[#e0e8ea] bg-white shadow-[0_10px_35px_#193d4610] dark:border-[#304753] dark:bg-[#132a35] dark:shadow-[0_14px_40px_#0004]">
            <div class="flex items-center justify-between border-b border-[#e9eff0] px-6 py-5 phone:px-4 dark:border-[#2d4550]">
                <div><h2 class="font-bold text-[#29444f] dark:text-[#e0edf1]">Workspace roles</h2><p class="mt-1 text-xs text-[#89999f] dark:text-[#91a8b3]">{{ $roles->total() }} {{ Str::plural('role', $roles->total()) }} configured</p></div>
                <span class="rounded-full bg-[#e8f6f2] px-3 py-1.5 text-[10px] font-bold uppercase tracking-wide text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]">Web guard</span>
            </div>
            <div class="hidden grid-cols-[minmax(220px,1.5fr)_110px_130px_190px] gap-4 bg-[#f7f9fa] px-6 py-3 text-[10px] font-bold uppercase tracking-[1.2px] text-[#778b93] md:grid dark:bg-[#10242e] dark:text-[#8fa7b2]"><span>Role</span><span>Users</span><span>Permissions</span><span class="text-right">Actions</span></div>
            <div class="divide-y divide-[#e9eff0] dark:divide-[#2d4550]">
                @forelse ($roles as $role)
                    <article class="grid gap-4 px-6 py-5 transition-colors hover:bg-[#f8fbfa] md:grid-cols-[minmax(220px,1.5fr)_110px_130px_190px] md:items-center phone:px-4 dark:hover:bg-[#18343e]">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $role->name === 'admin' ? 'bg-[#e6f5f1] text-[#168f80] dark:bg-[#1e4a43] dark:text-[#77dec7]' : 'bg-[#edf2f4] text-[#5f7881] dark:bg-[#203945] dark:text-[#aac0ca]' }}"><x-care-icon name="shield" class="h-5 w-5" /></span>
                            <div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><span class="truncate font-bold capitalize text-[#29444f] dark:text-[#e3eef2]">{{ str_replace('_', ' ', $role->name) }}</span>@if ($role->name === 'admin')<span class="rounded-full bg-[#e8f6f2] px-2 py-0.5 text-[9px] font-bold uppercase text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]">Protected</span>@endif</div><code class="mt-1 block truncate text-[10px] text-[#94a2a8] dark:text-[#78909b]">{{ $role->name }}</code></div>
                        </div>
                        <div class="flex items-center justify-between md:block"><span class="text-[10px] font-bold uppercase tracking-wide text-[#8b9aa0] md:hidden dark:text-[#8199a4]">Users</span><span class="inline-flex min-w-8 justify-center rounded-lg bg-[#f0f4f5] px-2.5 py-1.5 text-xs font-bold text-[#506972] dark:bg-[#203945] dark:text-[#b5c8d0]">{{ $role->users_count }}</span></div>
                        <div class="flex items-center justify-between md:block"><span class="text-[10px] font-bold uppercase tracking-wide text-[#8b9aa0] md:hidden dark:text-[#8199a4]">Permissions</span><span class="inline-flex min-w-8 justify-center rounded-lg bg-[#f0f4f5] px-2.5 py-1.5 text-xs font-bold text-[#506972] dark:bg-[#203945] dark:text-[#b5c8d0]">{{ $role->permissions_count }}</span></div>
                        <div class="flex justify-end gap-2 border-t border-[#edf1f2] pt-4 md:border-0 md:pt-0 dark:border-[#2d4550]">
                            @can('update', $role)@if ($role->name !== 'admin')<a href="{{ route('roles.edit', $role) }}" class="rounded-lg border border-[#d5e0e2] bg-white px-3.5 py-2 text-xs font-semibold text-[#397168] hover:bg-[#edf7f4] dark:border-[#405966] dark:bg-[#172f3a] dark:text-[#8addc8] dark:hover:bg-[#20433e]">Edit</a>@endif @endcan
                            @can('delete', $role)@if ($role->name !== 'admin')<form method="POST" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 bg-white px-3.5 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 dark:border-[#68404a] dark:bg-[#172f3a] dark:text-[#ff9aa7] dark:hover:bg-[#3a252c]">Delete</button></form>@endif @endcan
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-16 text-center"><div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-[#edf5f3] text-[#168f80] dark:bg-[#1d423d] dark:text-[#78dac4]"><x-care-icon name="shield" /></div><p class="mt-4 text-sm font-semibold text-[#506872] dark:text-[#c7d7dd]">No roles found</p></div>
                @endforelse
            </div>
        </section>
        @if ($roles->hasPages())<div class="mt-5 dark:text-[#b4c5cc]">{{ $roles->links() }}</div>@endif
    </div>
</x-app-layout>
