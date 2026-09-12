@php
    $selectedPermissions = collect(old('permissions', $role?->permissions?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id);
    $permissionCount = $permissions->flatten()->count();
@endphp

<div class="space-y-8" x-data="{
    toggleAll(checked) { this.$root.querySelectorAll('input[name=\'permissions[]\']').forEach(item => item.checked = checked) },
    toggleGroup(group, checked) { this.$root.querySelectorAll('[data-group=\'' + group + '\']').forEach(item => item.checked = checked) }
}">
    <div>
        <label for="name" class="block text-sm font-bold text-[#29444f] dark:text-[#dce8ed]">Role name</label>
        <div class="relative mt-2">
            <span class="pointer-events-none absolute inset-y-0 left-0 grid w-11 place-items-center text-[#8ba0a7] dark:text-[#76909c]"><x-care-icon name="shield" class="h-[18px] w-[18px]" /></span>
            <input id="name" name="name" type="text" value="{{ old('name', $role?->name) }}" required autofocus placeholder="Example: accounts_manager"
                class="w-full rounded-xl border-[#d8e2e4] bg-[#fbfcfc] py-3 pl-11 pr-4 text-sm text-[#29444f] shadow-sm placeholder:text-[#a8b4b8] focus:border-[#28ae9a] focus:bg-white focus:ring-[#28ae9a] dark:border-[#405762] dark:bg-[#10242e] dark:text-[#e5eff2] dark:placeholder:text-[#6f8792] dark:focus:border-[#58cfb8] dark:focus:bg-[#17323b] dark:focus:ring-[#58cfb8]">
        </div>
        <p class="mt-2 text-xs leading-5 text-[#82939a] dark:text-[#91a7b1]">Spaces will be converted to underscores. Letters, numbers, dots and hyphens are supported.</p>
        @error('name')<p class="mt-2 text-xs font-medium text-red-600 dark:text-[#ff9aa7]">{{ $message }}</p>@enderror
    </div>

    <section>
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div><h3 class="text-sm font-bold text-[#29444f] dark:text-[#dce8ed]">Permissions</h3><p class="mt-1 text-xs text-[#82939a] dark:text-[#91a7b1]">Choose what users with this role can access and change.</p></div>
            @if ($permissionCount > 0)
                <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#dbe5e6] bg-[#f8fbfa] px-3 py-2 text-xs font-bold text-[#397168] dark:border-[#405762] dark:bg-[#10242e] dark:text-[#8addc8]">
                    <input type="checkbox" @change="toggleAll($event.target.checked)" class="h-4 w-4 rounded border-[#b9cbce] text-[#168f80] focus:ring-[#39bda9] dark:border-[#526772] dark:bg-[#172f3a]"> Select all
                </label>
            @endif
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            @forelse ($permissions as $group => $groupPermissions)
                <div class="overflow-hidden rounded-xl border border-[#e1e9ea] bg-[#fbfcfc] dark:border-[#354e5a] dark:bg-[#10242e]">
                    <div class="flex items-center justify-between border-b border-[#e5ecee] bg-[#f4f8f8] px-4 py-3 dark:border-[#354e5a] dark:bg-[#172f3a]">
                        <h4 class="text-xs font-bold capitalize text-[#36535d] dark:text-[#d5e4e9]">{{ str_replace(['-', '_'], ' ', $group) }}</h4>
                        <label class="flex cursor-pointer items-center gap-1.5 text-[10px] font-semibold text-[#668087] dark:text-[#91a9b3]"><input type="checkbox" @change="toggleGroup('{{ $group }}', $event.target.checked)" class="h-3.5 w-3.5 rounded border-[#b9cbce] text-[#168f80] focus:ring-[#39bda9] dark:border-[#526772] dark:bg-[#10242e]"> All</label>
                    </div>
                    <div class="grid gap-1 p-2">
                        @foreach ($groupPermissions as $permission)
                            <label class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-[#eef6f4] dark:hover:bg-[#1c3a3e]">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" data-group="{{ $group }}" @checked($selectedPermissions->contains($permission->id))
                                    class="h-[18px] w-[18px] rounded border-[#b9cbce] text-[#168f80] focus:ring-[#39bda9] dark:border-[#526772] dark:bg-[#172f3a] dark:checked:bg-[#20aa96]">
                                <span class="min-w-0"><span class="block text-xs font-semibold capitalize text-[#415b64] dark:text-[#c9d9df]">{{ str($permission->name)->after('.')->replace(['-', '_'], ' ') }}</span><code class="mt-0.5 block truncate text-[9px] text-[#94a3a8] dark:text-[#728b96]">{{ $permission->name }}</code></span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-[#d8e2e4] px-5 py-8 text-center text-xs text-[#82939a] dark:border-[#405762] dark:text-[#91a7b1]">No permissions are available for the web guard.</div>
            @endforelse
        </div>
        @error('permissions.*')<p class="mt-3 text-xs font-medium text-red-600 dark:text-[#ff9aa7]">{{ $message }}</p>@enderror
    </section>
</div>
