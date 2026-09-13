@php
    $titles = [
        'overview' => 'A little overview. A lot of control.',
        'connections' => 'Every connection, one place.',
        'billing' => 'Your bills, all together.',
        'packages' => 'Your packages and expiry dates, in one place.',
        'usage' => 'Understand your connection.',
        'support' => 'Let’s get you connected.',
    ];
@endphp
<x-app-layout>
    <x-slot name="toolbar">
        <form method="GET" action="{{ url()->current() }}" class="care-connection-filter flex gap-[8px] items-center [border:1px_solid_#e2e8e9] pl-[12px] rounded-[9px] bg-[#fcfdfd] text-[#188f80] [&_.care-icon]:w-[17px] [&_select]:bg-[transparent] [&_select]:[border:0] [&_select]:max-w-[185px] [&_select]:p-[10px_33px_10px_1px] [&_select]:text-[12px] [&_select]:text-[#34474d] [&_select]:shadow-none phone:pl-[8px] phone:[&_select]:max-w-[150px] phone:[&_select]:text-[11px] phone:[&_>_.care-icon]:hidden dark:bg-[#192d3a] dark:border-[#344b59] dark:text-[#74d8c2] dark:[&_select]:text-[#dce8ee] dark:[&_option]:bg-[#192d3a] dark:[&_option]:text-[#dce8ee] small-phone:[&_select]:max-w-[118px] small-phone:[&_select]:pr-[27px]">
            <x-care-icon name="wifi" />
            <label for="connection-filter" class="sr-only">Select connection</label>
            <select id="connection-filter" name="connection" onchange="this.form.submit()">
                <option value="">All connections</option>
                @foreach ($connections as $connection)
                    <option value="{{ $connection->id }}" @selected($selected?->id === $connection->id)>{{ $connection->name }}</option>
                @endforeach
            </select>
            <noscript><button type="submit">Apply</button></noscript>
        </form>
    </x-slot>

    <div class="care-intro flex items-center justify-between gap-[20px] mb-[27px] [&_h1]:text-[29px] [&_h1]:font-[720] [&_h1]:tracking-[-1px] [&_h1]:text-[#1b3440] [&_h1]:m-[8px_0_7px] [&_h1]:leading-[1.25] [&_p]:text-[13px] [&_p]:text-[#82909a] phone:mb-[22px] phone:[&_h1]:text-[26px] dark:[&_h1]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2]">
        <div>
            <div class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">
                {{ $section === 'overview' ? 'YOUR PERSONAL CONNECTION HUB' : 'YOUR WORKSPACE / ' . strtoupper($section) }}
            </div>
            <h1>{{ $section === 'overview' ? 'Hello, ' . \Illuminate\Support\Str::before(auth()->user()->name, ' ') . ' 👋' : ucwords(str_replace('billing', 'bills & payments', $section)) }}
            </h1>
            <p>{{ $titles[$section] }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <span class="care-date flex gap-[8px] items-center text-[#7e8e96] text-[11px] whitespace-nowrap [&_.care-icon]:w-[15px] phone:hidden dark:text-[#8faab9]"><x-care-icon name="clock" />{{ now()->format('D, d M Y') }}</span>
            @php($createPermissions = ['overview' => 'dashboard.view', 'connections' => 'connection.create', 'billing' => 'invoice.create', 'usage' => 'usage.view', 'support' => 'support.create'])
            @if (! in_array($section, ['packages', 'overview'], true) && auth()->user()->can($createPermissions[$section]))
            <a href="{{ route(($section === 'overview' ? 'dashboard' : $section).'.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-teal-200 dark:border-[#38645b] bg-white dark:bg-[#142532] px-4 py-3 text-xs font-semibold text-teal-700 dark:text-[#8addc8] shadow-sm hover:bg-teal-50 dark:[&:hover]:bg-[#235348]">{{ ['connections' => 'Connection form', 'billing' => 'Invoice form', 'packages' => 'Package form', 'usage' => 'Report form', 'support' => 'New ticket'][$section] }} <span aria-hidden="true">+</span></a>
            @endif
        </div>
    </div>

    @yield('content')
</x-app-layout>
