@extends('care.page')

@section('content')
    <x-care.record-list :records="$records" module="usage" title="Saved report criteria" />
    <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2] care-empty text-center flex flex-col items-center p-[31px_25px_37px] [&_h3]:text-[14px] [&_h3]:font-semibold [&_h3]:text-[#425964] [&_p]:text-[12px] [&_p]:leading-[1.85] [&_p]:text-[#89969c] [&_p]:max-w-[335px] [&_p]:m-[9px_0_17px] phone:p-[27px_20px] dark:[&_h3]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] care-empty-large [&.care-empty-large]:p-[70px_25px] [&_h2]:text-[25px] [&_h2]:mt-[15px] [&_p]:max-w-[470px]"><span class="care-empty-icon grid place-items-center w-[59px] h-[59px] [border:1px_solid_#dfede9] bg-[#f0f8f5] text-[#68a998] rounded-[18px] mb-[16px] [&_.care-icon]:w-[27px] [&_.care-icon]:h-[27px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon
                name="chart" /></span><span class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">USAGE INSIGHTS</span>
        <h2>A clearer picture of your connection.</h2>
        <p>Usage reports are not available yet. Once your provider enables reporting, you can check data usage and session
            history here.</p><a class="care-button inline-flex items-center justify-center gap-[16px] bg-[#078d7e] text-[white] rounded-[8px] p-[12px_17px] text-[12px] font-[650] [&:hover]:bg-[#067869] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[16px]"
            href="{{ route('connections.index', array_filter(['connection' => $selected?->id])) }}">View my connections
            <x-care-icon name="arrow" /></a>
    </section>
@endsection
