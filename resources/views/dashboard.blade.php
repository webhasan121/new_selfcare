@extends('care.page')

@section('content')
    <section class="care-hero relative overflow-hidden rounded-[18px] [background:linear-gradient(115deg,_#087c75,_#07948a_65%,_#32afa0)] min-h-[280px] text-[white] flex items-center p-[32px_38px] [&_h2]:text-[35px] [&_h2]:tracking-[-1px] [&_h2]:leading-[1.18] [&_h2]:font-[680] [&_h2]:m-[14px_0_12px] [&_p]:text-[12px] [&_p]:leading-[1.85] [&_p]:text-[#c0e9e2] [&_p]:mb-[20px] wide:min-h-[310px] phone:min-h-[300px] phone:p-[27px_23px] phone:[&_h2]:text-[31px] dark:[background:linear-gradient(115deg,#075b5b,#086f68_65%,#198a79)]">
        <div class="care-hero-copy z-[1] below-xl:max-w-[58%] phone:max-w-[100%] phone:[&_p]:text-[11px]"><span class="care-hero-tag text-[9px] tracking-[2px] flex items-center gap-[8px] text-[#bbede2] font-[650] [&_>_span]:w-[5px] [&_>_span]:h-[5px] [&_>_span]:rounded-full [&_>_span]:bg-[#83e9b9]"><span></span> YOUR WORLD. CONNECTED.</span>
            <h2>More living.<br>Less managing.</h2>
            <p>Your connections, bills and account.<br>All the essentials, right where you need them.</p>
            <div class="flex flex-wrap items-center gap-3"><a
                class="care-button inline-flex items-center justify-center gap-[16px] bg-[#078d7e] text-[white] rounded-[8px] p-[12px_17px] text-[12px] font-[650] [&:hover]:bg-[#067869] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[16px] care-button-white [&.care-button-white]:bg-[white] [&.care-button-white]:text-[#077f74] [&:hover]:bg-[#e7fff7] dark:[&.care-button-white]:bg-[#dfefe9] dark:[&.care-button-white]:text-[#125f54] dark:[&:hover]:bg-[#c1e5d8]"
                href="{{ route('connections.index', array_filter(['connection' => $selected?->id])) }}">Manage connections
                <x-care-icon name="arrow" /></a>
                <a href="http://172.20.21.22/" target="_blank" rel="noopener noreferrer"
                    aria-label="Movie server (opens in a new tab)"
                    class="group relative isolate inline-flex items-center justify-center gap-2 rounded-lg border border-white/40 bg-white/10 px-4 py-3 text-xs font-semibold text-white shadow-sm backdrop-blur-sm transition motion-safe:hover:-translate-y-0.5 motion-safe:hover:scale-105 hover:border-white/70 hover:bg-white/20 hover:shadow-lg hover:shadow-teal-300/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                    <span aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 rounded-lg bg-teal-200/15 shadow-[0_0_18px_rgba(94,234,212,0.4)] motion-safe:animate-pulse motion-safe:[animation-duration:3s]"></span>
                    <span aria-hidden="true" class="absolute -right-1 -top-1 flex h-2.5 w-2.5"><span class="absolute inline-flex h-full w-full rounded-full bg-amber-300 opacity-60 motion-safe:animate-ping motion-safe:[animation-duration:2.5s]"></span><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-amber-300"></span></span>
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="3"/><path d="m10 8 6 4-6 4V8Z"/></svg>
                    Movie server
                    <svg class="h-3.5 w-3.5 transition-transform motion-safe:group-hover:-translate-y-0.5 motion-safe:group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>
                </a>
            </div>
        </div>
        <div class="care-network-art absolute right-[4%] top-[50%] w-[330px] h-[280px] [transform:translateY(-50%)] wide:right-[12%] below-xl:right-[0] below-xl:[scale:0.88] phone:right-[-175px] phone:opacity-[0.25] phone:pointer-events-none" aria-hidden="true">
            <div class="care-orbit absolute [border:1px_solid_#ffffff23] rounded-full top-[50%] left-[50%] [transform:translate(-50%,_-50%)] care-orbit-one w-[185px] h-[185px]"></div>
            <div class="care-orbit absolute [border:1px_solid_#ffffff23] rounded-full top-[50%] left-[50%] [transform:translate(-50%,_-50%)] care-orbit-two w-[280px] h-[280px]"></div>
            <div class="care-orbit absolute [border:1px_solid_#ffffff23] rounded-full top-[50%] left-[50%] [transform:translate(-50%,_-50%)] care-orbit-three w-[400px] h-[400px]"></div>
            <div class="care-art-core absolute left-[50%] top-[50%] [transform:translate(-50%,_-50%)] w-[122px] h-[122px] rounded-[30px] flex flex-col items-center justify-center gap-[13px] [background:linear-gradient(145deg,_#ffffff30,_#ffffff08)] shadow-[0_12px_40px_#075e6240] [border:1px_solid_#ffffff50] [rotate:-8deg] [&_.care-icon]:w-[60px] [&_.care-icon]:h-[60px] [&_.care-icon]:[stroke-width:1.3] [&_span]:text-[6px] [&_span]:tracking-[1.3px]"><x-care-icon name="wifi" /><span>CONNECTED TO YOU</span></div>
            <div class="care-art-node absolute flex gap-[10px] items-center [border:1px_solid_#ffffff55] bg-[#ffffffed] text-[#26766f] p-[12px_17px] rounded-[12px] shadow-[0_10px_25px_#075e6220] text-[11px] font-[650] care-art-home top-[34px] left-[2px] [rotate:-7deg]"><x-care-icon name="home" /><span>Home</span></div>
            <div class="care-art-node absolute flex gap-[10px] items-center [border:1px_solid_#ffffff55] bg-[#ffffffed] text-[#26766f] p-[12px_17px] rounded-[12px] shadow-[0_10px_25px_#075e6220] text-[11px] font-[650] care-art-office bottom-[28px] right-[0] [rotate:7deg]"><x-care-icon name="box" /><span>Office</span></div>
            <div class="care-art-dot w-[11px] h-[11px] rounded-full bg-[#b9f1cf] absolute right-[26px] top-[58px] shadow-[0_0_0_7px_#ffffff13]"></div>
        </div>
    </section>

    <div class="care-stats grid grid-cols-[repeat(3,_minmax(0,_1fr))] gap-[18px] m-[22px_0] phone:gap-[8px] phone:m-[14px_0_20px]">
        <div class="care-stat flex gap-[17px] items-start bg-[white] [border:1px_solid_#e7ecef] rounded-[13px] p-[23px] [&_p]:text-[11px] [&_p]:text-[#7a8a92] [&_p]:mb-[5px] [&_strong]:text-[27px] [&_strong]:tracking-[-0.7px] [&_strong]:text-[#253e47] [&_strong]:block [&_strong]:font-bold [&_strong]:leading-[1.3] [&_strong_small]:text-[11px] [&_strong_small]:font-[450] [&_strong_small]:text-[#8a989d] [&_strong_small]:tracking-[0] [&_strong_small]:ml-[8px] [&_div_>_span]:text-[9px] [&_div_>_span]:text-[#84949a] [&_div_>_span]:block [&_div_>_span]:mt-[5px] below-xl:p-[18px_15px] below-xl:gap-[12px] below-xl:[&_div_>_span]:text-[9px] phone:p-[14px_10px] phone:block phone:[&_p]:text-[9px] phone:[&_strong]:text-[23px] phone:[&_strong_small]:hidden phone:[&_div_>_span]:text-[8px] phone:[&_div_>_span]:leading-[1.7] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_strong]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] dark:[&_div>span]:text-[#a3b6c2]"><span class="care-stat-icon grid place-items-center rounded-[12px] w-[45px] h-[45px] text-[#3089b0] bg-[#eaf4fa] shrink-0 below-xl:w-[36px] below-xl:h-[36px] phone:w-[29px] phone:h-[29px] phone:rounded-[8px] phone:mb-[10px] phone:[&_.care-icon]:w-[16px] phone:[&_.care-icon]:h-[16px] dark:bg-[#203f55] dark:text-[#84c8ed]"><x-care-icon name="wifi" /></span>
            <div>
                <p>Connections</p>
                <strong>{{ $visibleConnections->count() }}<small>linked</small></strong><span>{{ $selected ? $selected->name : 'Across your account' }}</span>
            </div>
        </div>
        <div class="care-stat flex gap-[17px] items-start bg-[white] [border:1px_solid_#e7ecef] rounded-[13px] p-[23px] [&_p]:text-[11px] [&_p]:text-[#7a8a92] [&_p]:mb-[5px] [&_strong]:text-[27px] [&_strong]:tracking-[-0.7px] [&_strong]:text-[#253e47] [&_strong]:block [&_strong]:font-bold [&_strong]:leading-[1.3] [&_strong_small]:text-[11px] [&_strong_small]:font-[450] [&_strong_small]:text-[#8a989d] [&_strong_small]:tracking-[0] [&_strong_small]:ml-[8px] [&_div_>_span]:text-[9px] [&_div_>_span]:text-[#84949a] [&_div_>_span]:block [&_div_>_span]:mt-[5px] below-xl:p-[18px_15px] below-xl:gap-[12px] below-xl:[&_div_>_span]:text-[9px] phone:p-[14px_10px] phone:block phone:[&_p]:text-[9px] phone:[&_strong]:text-[23px] phone:[&_strong_small]:hidden phone:[&_div_>_span]:text-[8px] phone:[&_div_>_span]:leading-[1.7] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_strong]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] dark:[&_div>span]:text-[#a3b6c2]"><span class="care-stat-icon grid place-items-center rounded-[12px] w-[45px] h-[45px] text-[#3089b0] bg-[#eaf4fa] shrink-0 below-xl:w-[36px] below-xl:h-[36px] phone:w-[29px] phone:h-[29px] phone:rounded-[8px] phone:mb-[10px] phone:[&_.care-icon]:w-[16px] phone:[&_.care-icon]:h-[16px] dark:bg-[#203f55] dark:text-[#84c8ed] care-icon-green [&.care-icon-green]:bg-[#e8f7f0] [&.care-icon-green]:text-[#239b76] dark:[&.care-icon-green]:bg-[#20483e] dark:[&.care-icon-green]:text-[#77d5b0]"><x-care-icon name="check" /></span>
            <div>
                <p>Active services</p>
                <strong>{{ $visibleConnections->where('status', 'active')->count() }}<small>active</small></strong><span>Service
                    status, not live connectivity</span>
            </div>
        </div>
        <a class="care-stat flex gap-[17px] items-start bg-[white] [border:1px_solid_#e7ecef] rounded-[13px] p-[23px] [&_p]:text-[11px] [&_p]:text-[#7a8a92] [&_p]:mb-[5px] [&_strong]:text-[27px] [&_strong]:tracking-[-0.7px] [&_strong]:text-[#253e47] [&_strong]:block [&_strong]:font-bold [&_strong]:leading-[1.3] [&_strong_small]:text-[11px] [&_strong_small]:font-[450] [&_strong_small]:text-[#8a989d] [&_strong_small]:tracking-[0] [&_strong_small]:ml-[8px] [&_div_>_span]:text-[9px] [&_div_>_span]:text-[#84949a] [&_div_>_span]:block [&_div_>_span]:mt-[5px] below-xl:p-[18px_15px] below-xl:gap-[12px] below-xl:[&_div_>_span]:text-[9px] phone:p-[14px_10px] phone:block phone:[&_p]:text-[9px] phone:[&_strong]:text-[23px] phone:[&_strong_small]:hidden phone:[&_div_>_span]:text-[8px] phone:[&_div_>_span]:leading-[1.7] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_strong]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] dark:[&_div>span]:text-[#a3b6c2]" href="{{ route('billing.index', array_filter(['connection' => $selected?->id])) }}"><span
                class="care-stat-icon grid place-items-center rounded-[12px] w-[45px] h-[45px] text-[#3089b0] bg-[#eaf4fa] shrink-0 below-xl:w-[36px] below-xl:h-[36px] phone:w-[29px] phone:h-[29px] phone:rounded-[8px] phone:mb-[10px] phone:[&_.care-icon]:w-[16px] phone:[&_.care-icon]:h-[16px] dark:bg-[#203f55] dark:text-[#84c8ed] care-icon-orange [&.care-icon-orange]:bg-[#fff3e6] [&.care-icon-orange]:text-[#ce9246] dark:[&.care-icon-orange]:bg-[#493c29] dark:[&.care-icon-orange]:text-[#ecc184]"><x-care-icon name="bill" /></span>
            <div>
                <p>Open invoices</p><strong>{{ $unpaidCount }}<small>to review</small></strong><span>View your billing
                    details <span aria-hidden="true">↗</span></span>
            </div>
        </a>
    </div>
    <div class="care-overview-grid grid grid-cols-[1.25fr_1fr] gap-[22px] below-xl:grid-cols-[1fr_1fr] phone:grid-cols-[1fr] phone:gap-[18px]">
        <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2]">
            <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
                <div>
                    <h2>My connections</h2>
                    <p>A space for every part of your day.</p>
                </div><a class="care-text-link inline-flex items-center gap-[7px] text-[#138f7f] text-[11px] font-[650] whitespace-nowrap [&_.care-icon]:w-[15px] dark:text-[#68d6bd]"
                    href="{{ route('connections.index', array_filter(['connection' => $selected?->id])) }}">View all
                    <x-care-icon name="arrow" /></a>
            </div>@include('care.connections', ['connectionRows' => $visibleConnections->take(3)])
        </section>
        <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2]">
            <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
                <div>
                    <h2>Quick access</h2>
                    <p>A little less clicking.</p>
                </div>
            </div>
            <div class="care-quick-links p-[0_25px] [&_>_a]:flex [&_>_a]:items-center [&_>_a]:gap-[13px] [&_>_a]:p-[16px_0] [&_>_a]:[border-bottom:1px_solid_#eff2f3] [&_>_a:last-child]:[border:0] [&_>_a_>_.care-icon]:w-[16px] [&_>_a_>_.care-icon]:text-[#85989e] [&_>_a_>_.care-icon]:ml-[auto] [&_strong]:block [&_strong]:text-[12px] [&_strong]:font-semibold [&_strong]:text-[#41565e] [&_small]:text-[10px] [&_small]:text-[#8c9a9f] [&_small]:block [&_small]:mt-[4px] dark:[&_strong]:text-[#e2edf2] dark:[&_small]:text-[#a3b6c2] dark:[&>a]:border-[#293e4c]">
                @foreach ([['billing', 'bill', 'Bills & payments', 'Review invoices and payment history'], ['packages', 'box', 'Explore packages', 'Find a plan that fits your needs'], ['support', 'help', 'Need a hand?', 'Helpful answers, all in one place']] as [$page, $icon, $title, $description])
                    <a href="{{ route($page . '.index', array_filter(['connection' => $selected?->id])) }}"><span
                            class="care-quick-icon bg-[#f3f7f7] rounded-[10px] w-[37px] h-[37px] grid place-items-center text-[#64868b] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon
                                :name="$icon" /></span><span><strong>{{ $title }}</strong><small>{{ $description }}</small></span><x-care-icon
                            name="arrow" /></a>
                @endforeach
            </div>
            <div class="care-account-note flex items-center gap-[10px] m-[10px_23px_22px] bg-[#f0f8f5] p-[14px] rounded-[10px] text-[#4b9583] [&_p]:text-[9px] [&_p]:leading-[1.8] [&_p]:text-[#78938b] [&_strong]:text-[#437f70] [&_strong]:font-semibold [&_>_a]:ml-[auto] [&_.care-icon]:w-[17px] dark:bg-[#193b38] dark:border-[#33544b] dark:text-[#addacf] dark:[&_p]:text-[#a4d2c7] dark:[&_strong]:text-[#a4d2c7] dark:[&>a]:text-[#68d6bd]"><x-care-icon name="shield" />
                <p><strong>Your account, your space.</strong><br>Keep your contact details up to date.</p><a
                    href="{{ route('profile.edit') }}" aria-label="Update profile"><x-care-icon name="arrow" /></a>
            </div>
        </section>
    </div>
    <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2] care-section-gap mt-[22px]">
        <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
            <div>
                <h2>Recent invoices</h2>
                <p>Stay on top of the details.</p>
            </div><a class="care-text-link inline-flex items-center gap-[7px] text-[#138f7f] text-[11px] font-[650] whitespace-nowrap [&_.care-icon]:w-[15px] dark:text-[#68d6bd]"
                href="{{ route('billing.index', array_filter(['connection' => $selected?->id])) }}">View billing
                <x-care-icon name="arrow" /></a>
        </div>@include('care.invoices', ['invoiceRows' => $invoices->take(5)])
    </section>
@endsection
