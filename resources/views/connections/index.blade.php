@extends('care.page')

@section('content')
    <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2]">
        <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
            <div>
                <h2>{{ $selected?->name ?? 'Your connections' }}</h2>
                <p>View service details and the current subscription.</p>
            </div><span class="care-count text-[11px] text-[#698d83] bg-[#eff7f3] p-[6px_10px] rounded-[6px] dark:bg-[#1d443a] dark:text-[#83dabc]">{{ $visibleConnections->count() }} linked</span>
        </div>@include('care.connections', ['connectionRows' => $visibleConnections])
    </section>
@endsection
