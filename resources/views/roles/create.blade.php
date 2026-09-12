<x-app-layout>
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('roles.index') }}" class="mb-5 inline-flex items-center gap-2 text-xs font-semibold text-[#628078] hover:text-[#168f80] dark:text-[#93aaa5] dark:hover:text-[#75d7c1]">← Back to roles</a>
        <div class="mb-7"><div class="text-[9px] font-bold tracking-[1.8px] text-[#6d8991] dark:text-[#8faab9]">ADMINISTRATION / ROLES</div><h1 class="mt-2 text-[30px] font-bold tracking-[-1px] text-[#183440] dark:text-[#e5f0f4]">Create a new role</h1><p class="mt-1 text-[13px] text-[#7d8f97] dark:text-[#9db0bb]">Add a reusable access group for your team.</p></div>
        <form method="POST" action="{{ route('roles.store') }}" class="overflow-hidden rounded-2xl border border-[#e0e8ea] bg-white shadow-[0_10px_35px_#193d4610] dark:border-[#304753] dark:bg-[#132a35] dark:shadow-[0_14px_40px_#0004]">
            @csrf
            <div class="flex items-center gap-4 border-b border-[#e9eff0] px-6 py-5 dark:border-[#2d4550]"><span class="grid h-11 w-11 place-items-center rounded-xl bg-[#e8f6f2] text-[#168f80] dark:bg-[#1b443e] dark:text-[#79dbc5]"><x-care-icon name="shield" /></span><div><h2 class="font-bold text-[#29444f] dark:text-[#e0edf1]">Role details</h2><p class="mt-1 text-xs text-[#89999f] dark:text-[#91a8b3]">Give the role a clear, recognizable name.</p></div></div>
            <div class="p-6">@include('roles.fields', ['role' => null])</div>
            <div class="flex flex-wrap justify-end gap-3 border-t border-[#e9eff0] bg-[#fafcfc] px-6 py-4 dark:border-[#2d4550] dark:bg-[#10242e]"><a href="{{ route('roles.index') }}" class="rounded-xl border border-[#d5e0e2] bg-white px-5 py-3 text-xs font-bold text-[#60767e] hover:bg-[#f1f5f5] dark:border-[#405966] dark:bg-[#172f3a] dark:text-[#b3c5cd] dark:hover:bg-[#203945]">Cancel</a><button class="rounded-xl bg-[#168f80] px-5 py-3 text-xs font-bold text-white shadow-[0_6px_16px_#168f8025] hover:bg-[#11796d] dark:bg-[#20aa96] dark:text-[#071f25] dark:hover:bg-[#55d5bd]">Create role</button></div>
        </form>
    </div>
</x-app-layout>
