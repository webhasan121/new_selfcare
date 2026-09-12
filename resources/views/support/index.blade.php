@extends('care.page')

@section('content')
    <x-care.record-list :records="$records" module="support" :title="$canViewAllTickets ? 'All customer support tickets' : 'Your support tickets'" :show-owner="$canViewAllTickets" />
    <div class="care-support-grid grid grid-cols-[1.5fr_1fr] gap-[22px] phone:grid-cols-[1fr] phone:gap-[18px]">
        <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2] care-faq p-[30px] [&_h2]:text-[23px] [&_h2]:m-[10px_0_25px] [&_details]:[border-top:1px_solid_#e7eeee] [&_details]:p-[20px_0] [&_summary]:text-[13px] [&_summary]:font-semibold [&_summary]:cursor-pointer [&_summary]:flex [&_summary]:justify-between [&_summary]:gap-[20px] [&_summary]:list-none [&_summary_span]:text-[#229381] [&_details_p]:text-[12px] [&_details_p]:leading-[1.9] [&_details_p]:text-[#7a9097] [&_details_p]:mt-[15px] dark:[&_details_p]:text-[#a3b6c2] dark:[&_details]:border-[#293e4c] dark:[&_summary]:text-[#d6e5ec]"><span class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">A LITTLE GUIDANCE</span>
            <h2>Good questions. Simple answers.</h2>
            @foreach (['How do I switch between Home and Office?' => 'Use the connection selector in the top bar. Choose a connection to view its service and billing details, or All connections for your account overview.', 'Where can I find my invoices?' => 'Open Bills & payments. Each invoice shows its connection, billed amount, due date and recorded status.', 'Can I pay more than one invoice together?' => 'Online checkout is not available yet. When enabled, combined payments can include invoices from multiple connections on your account.', 'How do I update my contact details?' => 'Open My profile to see the account settings currently available.'] as $question => $answer)
                <details>
                    <summary>{{ $question }}<span>+</span></summary>
                    <p>{{ $answer }}</p>
                </details>
            @endforeach
        </section>
        <section class="care-panel bg-[white] [border:1px_solid_#e6ecee] rounded-[14px] overflow-hidden [&_h2]:text-[16px] [&_h2]:font-[680] [&_h2]:tracking-[-0.3px] [&_h2]:text-[#29424c] phone:[&_h2]:text-[15px] dark:bg-[#142532] dark:border-[#2c414f] dark:[&_h2]:text-[#e2edf2] care-support-card p-[30px] [&_>_p]:text-[12px] [&_>_p]:text-[#7a9097] [&_>_p]:leading-[1.9] [&_>_p]:m-[15px_0_22px] [&_.care-notice]:p-[14px] dark:[&>p]:text-[#a3b6c2]"><span class="care-empty-icon grid place-items-center w-[59px] h-[59px] [border:1px_solid_#dfede9] bg-[#f0f8f5] text-[#68a998] rounded-[18px] mb-[16px] [&_.care-icon]:w-[27px] [&_.care-icon]:h-[27px] dark:bg-[#203c40] dark:border-[#36554f] dark:text-[#83cdbd]"><x-care-icon name="help" /></span>
            <h2>Need more help?</h2>
            <p>For connection issues, contact your internet provider using the support details on your service agreement.
            </p>
            <div class="care-notice flex items-center gap-[14px] bg-[#eaf5f2] [border:1px_solid_#dbece6] rounded-[12px] p-[18px_21px] text-[#4b7c71] mb-[22px] text-[12px] leading-[1.8] [&_strong]:font-[650] [&_p]:text-[12px] dark:bg-[#193b38] dark:border-[#33544b] dark:text-[#addacf]">
                <p>Create a ticket with your connection details so your issue is recorded in your account.</p>
            </div><a class="care-button inline-flex items-center justify-center gap-[16px] bg-[#078d7e] text-[white] rounded-[8px] p-[12px_17px] text-[12px] font-[650] [&:hover]:bg-[#067869] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[16px]" href="{{ route('profile.edit') }}">My account details <x-care-icon
                    name="arrow" /></a>
        </section>
    </div>
@endsection
