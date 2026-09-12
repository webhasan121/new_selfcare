@props(['records', 'module', 'title', 'showOwner' => false])
<section class="mb-6 overflow-hidden rounded-2xl border border-slate-200 dark:border-[#2e4655] bg-white dark:bg-[#142532] shadow-sm">
    <div class="flex items-center justify-between border-b border-slate-200 dark:border-[#2e4655] px-6 py-5"><h2 class="text-base font-bold text-slate-800 dark:text-[#e0ebf2]">{{ $title }}</h2><span class="rounded-lg bg-teal-50 dark:bg-[#193d39] px-3 py-1 text-xs font-semibold text-teal-700 dark:text-[#8addc8]">{{ $records->total() }} saved</span></div>
    @forelse($records as $item)
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 dark:border-[#2e4655] px-6 py-5">
            <div><a href="{{ route($module.'.show', $item) }}" class="text-sm font-bold text-teal-700 dark:text-[#8addc8] hover:underline">{{ $module === 'support' ? $item->subject : $item->start_date->format('d M Y').' - '.$item->end_date->format('d M Y') }}</a><p class="mt-2 text-xs text-slate-500 dark:text-[#b3c6d3]">{{ $item->connection->name }}@if($showOwner && $module === 'support') &middot; {{ $item->user->name }} ({{ $item->user->email }})@endif &middot; Saved {{ $item->created_at->format('d M Y') }}</p></div>
            <div class="flex items-center gap-4">@if($module === 'support')<x-care.status-badge :status="$item->status" />@endif<a href="{{ route($module.'.show', $item) }}" class="text-xs font-bold text-teal-700 dark:text-[#8addc8]">View details &rarr;</a></div>
        </div>
    @empty
        <div class="px-6 py-10 text-center"><p class="font-semibold text-slate-700 dark:text-[#e0ebf2]">No saved {{ $module === 'support' ? 'tickets' : 'report criteria' }} yet</p><p class="mt-2 text-sm text-slate-500 dark:text-[#b3c6d3]">Use the button above to create your first record.</p></div>
    @endforelse
    @if($records->hasPages())<div class="px-6 py-5">{{ $records->links() }}</div>@endif
</section>
