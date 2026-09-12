<x-app-layout>
    @php($selectedRoles = collect(old('roles', $managedUser->roles->pluck('id')->all()))->map(fn ($id) => (int) $id))
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('users.index') }}" class="mb-5 inline-flex text-xs font-semibold text-[#628078] hover:text-[#168f80] dark:text-[#93aaa5] dark:hover:text-[#75d7c1]">← Back to users</a>
        <div class="mb-7"><div class="text-[9px] font-bold tracking-[1.8px] text-[#6d8991] dark:text-[#8faab9]">ADMINISTRATION / USERS</div><h1 class="mt-2 text-[30px] font-bold tracking-[-1px] text-[#183440] dark:text-[#e5f0f4]">Manage user roles</h1><p class="mt-1 text-[13px] text-[#7d8f97] dark:text-[#9db0bb]">Choose which access groups apply to this user.</p></div>

        <form method="POST" action="{{ route('users.update', $managedUser) }}" class="overflow-hidden rounded-2xl border border-[#e0e8ea] bg-white shadow-[0_10px_35px_#193d4610] dark:border-[#304753] dark:bg-[#132a35] dark:shadow-[0_14px_40px_#0004]">
            @csrf @method('PUT')
            <div class="flex items-center gap-4 border-b border-[#e9eff0] px-6 py-5 dark:border-[#2d4550]"><span class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-[#e8f6f2] text-lg font-bold text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]">{{ mb_strtoupper(mb_substr($managedUser->name, 0, 1)) }}</span><div class="min-w-0"><h2 class="truncate font-bold text-[#29444f] dark:text-[#e0edf1]">{{ $managedUser->name }}</h2><p class="mt-1 truncate text-xs text-[#89999f] dark:text-[#91a8b3]">{{ $managedUser->email }}</p></div></div>
            <div class="p-6">
                <div class="mb-4"><h3 class="text-sm font-bold text-[#29444f] dark:text-[#dce8ed]">Assign roles</h3><p class="mt-1 text-xs text-[#82939a] dark:text-[#91a7b1]">A user receives all permissions attached to the selected roles.</p></div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($roles as $role)
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-[#e1e9ea] bg-[#fbfcfc] p-4 hover:border-[#92cfc4] hover:bg-[#f2f9f7] dark:border-[#354e5a] dark:bg-[#10242e] dark:hover:border-[#4c8e81] dark:hover:bg-[#18383a]">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($selectedRoles->contains($role->id)) class="h-5 w-5 rounded border-[#b9cbce] text-[#168f80] focus:ring-[#39bda9] dark:border-[#526772] dark:bg-[#172f3a] dark:checked:bg-[#20aa96]">
                            <span class="min-w-0"><span class="block font-bold capitalize text-[#36535d] dark:text-[#d5e4e9]">{{ str_replace('_', ' ', $role->name) }}</span><span class="mt-1 block text-[10px] text-[#89999f] dark:text-[#8198a3]">{{ $role->permissions_count }} {{ Str::plural('permission', $role->permissions_count) }}</span></span>
                        </label>
                    @endforeach
                </div>
                @error('roles')<p class="mt-3 text-xs font-medium text-red-600 dark:text-[#ff9aa7]">{{ $message }}</p>@enderror
                @error('roles.*')<p class="mt-3 text-xs font-medium text-red-600 dark:text-[#ff9aa7]">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end gap-3 border-t border-[#e9eff0] bg-[#fafcfc] px-6 py-4 dark:border-[#2d4550] dark:bg-[#10242e]"><a href="{{ route('users.index') }}" class="rounded-xl border border-[#d5e0e2] bg-white px-5 py-3 text-xs font-bold text-[#60767e] dark:border-[#405966] dark:bg-[#172f3a] dark:text-[#b3c5cd]">Cancel</a><button class="rounded-xl bg-[#168f80] px-5 py-3 text-xs font-bold text-white hover:bg-[#11796d] dark:bg-[#20aa96] dark:text-[#071f25] dark:hover:bg-[#55d5bd]">Save roles</button></div>
        </form>
    </div>
</x-app-layout>
