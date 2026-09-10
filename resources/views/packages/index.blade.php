@extends('care.page')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-amber-200 bg-amber-50 px-5 py-3 text-xs leading-6 text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
        <p><span class="font-bold">Demo preview</span> &middot; Sample packages and expiry date. These are not your live subscription details.</p>
        <span>Plan changes are coming soon.</span>
    </div>
    <div class="mb-5 flex items-center gap-3">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300"><x-care-icon name="box" /></span>
        <div><h2 class="text-lg font-bold text-slate-800 dark:text-slate-100">A plan for every kind of day</h2><p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Compare speeds and find your next package.</p></div>
    </div>
    <div class="grid items-stretch gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach($packages as $package)
            <article @class([
                'relative flex min-w-0 flex-col overflow-hidden rounded-2xl border p-6 sm:p-7',
                'border-teal-500 bg-gradient-to-br from-teal-700 to-teal-950 text-white shadow-xl shadow-teal-900/15 ring-2 ring-teal-500/20' => $package['active'],
                'border-slate-200 bg-white text-slate-800 shadow-sm dark:border-slate-700 dark:bg-[#142532] dark:text-slate-100' => ! $package['active'],
            ])>
                <div class="mb-7 flex items-center justify-between gap-3">
                    <span @class(['flex h-11 w-11 items-center justify-center rounded-xl', 'bg-white/15 text-teal-100' => $package['active'], 'bg-teal-50 text-teal-600 dark:bg-teal-900/30 dark:text-teal-300' => ! $package['active']])><x-care-icon name="wifi" /></span>
                    @if($package['active'])
                        <span class="inline-flex items-center gap-2 rounded-full border border-teal-300/30 bg-white/10 px-3 py-1.5 text-xs font-semibold text-teal-100"><span class="h-1.5 w-1.5 rounded-full bg-teal-300"></span>Active package</span>
                    @else
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Available plan</span>
                    @endif
                </div>
                <p @class(['text-[10px] font-semibold uppercase tracking-[0.18em]', 'text-teal-200' => $package['active'], 'text-slate-500 dark:text-slate-400' => ! $package['active']])>Package name</p>
                <h3 class="mt-2 text-xl font-bold">{{ $package['name'] }}</h3>
                <div class="my-6 flex items-baseline gap-2"><span class="text-5xl font-bold tracking-tight">{{ $package['speed_mbps'] }}</span><span @class(['text-sm', 'text-teal-200' => $package['active'], 'text-slate-500 dark:text-slate-400' => ! $package['active']])>Mbps</span></div>
                <p @class(['min-h-12 text-sm leading-6', 'text-teal-100/90' => $package['active'], 'text-slate-500 dark:text-slate-400' => ! $package['active']])>{{ $package['description'] }}</p>
                <p class="mt-6 text-2xl font-bold">&#2547;{{ number_format($package['price']) }}<span @class(['ml-1 text-xs font-normal', 'text-teal-200' => $package['active'], 'text-slate-500 dark:text-slate-400' => ! $package['active']])>/ month</span></p>
                <div @class(['mb-6 mt-6 flex items-center justify-between gap-3 border-t pt-5 text-xs', 'border-white/20' => $package['active'], 'border-slate-100 dark:border-slate-700' => ! $package['active']])>
                    <span @class(['flex items-center gap-2', 'text-teal-200' => $package['active'], 'text-slate-500 dark:text-slate-400' => ! $package['active']])><x-care-icon name="clock" class="!h-4 !w-4" />Expire date</span>
                    <span class="font-semibold">{{ $package['expire_date'] ?? 'Not started' }}</span>
                </div>
                @if($package['active'])
                    <div class="mt-auto flex min-h-12 items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-teal-800"><x-care-icon name="check" class="!h-4 !w-4" />Your current plan</div>
                @else
                    <button type="button" disabled aria-label="{{ $package['action'] }} to {{ $package['name'] }} — coming soon" class="mt-auto min-h-12 cursor-not-allowed rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-700 dark:border-teal-800 dark:bg-teal-900/30 dark:text-teal-300">{{ $package['action'] }} <span aria-hidden="true">&rarr;</span></button>
                @endif
            </article>
        @endforeach
    </div>
@endsection
