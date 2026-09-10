@extends('care.page')

@section('content')
    <div class="care-notice flex items-center gap-[14px] bg-[#eaf5f2] [border:1px_solid_#dbece6] rounded-[12px] p-[18px_21px] text-[#4b7c71] mb-[22px] text-[12px] leading-[1.8] [&_strong]:font-[650] [&_p]:text-[12px] dark:bg-[#193b38] dark:border-[#33544b] dark:text-[#addacf]">
        <x-care-icon name="bill" />
        <div><strong>All your billing details, together.</strong>
            <p>Online checkout is not available yet. Invoice amounts below are original billed amounts; payment allocations
                are shown separately.</p>
        </div>
    </div>
    <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2]">
        <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
            <h2>Invoices</h2><span class="care-count text-[11px] text-[#698d83] bg-[#eff7f3] p-[6px_10px] rounded-[6px] dark:bg-[#1d443a] dark:text-[#83dabc]">{{ $unpaidCount }} open</span>
        </div>@include('care.invoices', ['invoiceRows' => $invoices])<div class="care-pagination p-[0_24px] [&:has(nav)]:p-[20px_24px]">{{ $invoices->links() }}</div>
    </section>
    <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2] care-section-gap mt-[22px]">
        <div class="care-panel-heading p-[24px_25px_18px] flex items-center justify-between gap-[12px] [&_p]:text-[#8a969d] [&_p]:text-[11px] [&_p]:mt-[5px] below-xl:[padding-inline:20px] below-xl:[&_.care-text-link]:text-[10px] phone:p-[21px_18px_15px] phone:[&_p]:text-[10px] dark:[&_p]:text-[#a3b6c2]">
            <div>
                <h2>Payment history</h2>
                <p>Combined transactions include their connection allocations.</p>
            </div>
        </div>
        @forelse($payments as $payment)
            <div class="care-payment-row flex justify-between gap-[20px] p-[23px_25px] [border-top:1px_solid_#edf1f2] [&_strong]:text-[13px] [&_strong]:[overflow-wrap:anywhere] [&_p]:text-[11px] [&_p]:text-[#84969d] [&_p]:block [&_p]:mt-[7px] [&_small]:text-[11px] [&_small]:text-[#84969d] [&_small]:block [&_small]:mt-[7px] phone:p-[20px_15px] phone:gap-[12px] phone:[&_strong]:text-[11px] phone:[&_small]:text-[10px] dark:[&_strong]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] dark:[&_small]:text-[#a3b6c2] dark:border-[#293e4c]">
                <div><strong>{{ $payment->transaction_id }}</strong>
                    <p>{{ $payment->paid_at?->format('d M Y, h:i A') ?? 'Not yet paid' }} ·
                        {{ ucfirst($payment->payment_method) }}</p>
                    @foreach ($payment->items as $item)
                        <small>{{ $item->invoice?->connection?->name ?? 'Connection unavailable' }} ·
                            {{ $item->invoice?->invoice_number }} · ৳{{ number_format($item->amount, 2) }}</small>
                    @endforeach
                </div>
                <div class="care-payment-total text-right shrink-0 [&_.care-badge]:block [&_.care-badge]:mt-[8px]"><strong>৳{{ number_format($payment->total_amount, 2) }}</strong><span
                        class="care-badge inline-block text-[9px] font-semibold rounded-[5px] p-[5px_9px] bg-[#f3f1e9] text-[#95814d] whitespace-nowrap dark:bg-[#433c2b] dark:text-[#e9cc87]">{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</span></div>
            </div>
        @empty<div class="care-empty text-center flex flex-col items-center p-[31px_25px_37px] [&_h3]:text-[14px] [&_h3]:font-semibold [&_h3]:text-[#425964] [&_p]:text-[12px] [&_p]:leading-[1.85] [&_p]:text-[#89969c] [&_p]:max-w-[335px] [&_p]:m-[9px_0_17px] phone:p-[27px_20px] dark:[&_h3]:text-[#e2edf2] dark:[&_p]:text-[#a3b6c2] care-empty-compact [&.care-empty-compact]:p-[24px] [&_.care-empty-icon]:w-[43px] [&_.care-empty-icon]:h-[43px] [&_.care-empty-icon]:rounded-[12px] [&_.care-empty-icon]:mb-[10px] [&_.care-empty-icon_.care-icon]:w-[21px]"><span class="care-empty-icon grid place-items-center w-[59px] h-[59px] [border:1px_solid_#dfede9] bg-[#f0f8f5] text-[#68a998] rounded-[18px] mb-[16px] [&_.care-icon]:w-[27px] [&_.care-icon]:h-[27px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon
                        name="bill" /></span>
                <h3>Your payment story starts here</h3>
                <p>Payment transactions will appear here when they are recorded.</p>
            </div>
        @endforelse
        <div class="care-pagination p-[0_24px] [&:has(nav)]:p-[20px_24px]">{{ $payments->links() }}</div>
    </section>
@endsection
