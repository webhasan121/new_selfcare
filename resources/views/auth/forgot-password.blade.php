<x-guest-layout>
    <x-slot name="title">Forgot password</x-slot>
    <div class="auth-heading mb-[30px] [&_.care-eyebrow]:block [&_.care-eyebrow]:text-[#619082] [&_.care-eyebrow]:tracking-[1.7px] [&_.care-eyebrow]:text-[9px] [&_h1]:text-[34px] [&_h1]:tracking-[-1.2px] [&_h1]:font-bold [&_h1]:leading-[1.22] [&_h1]:text-[#213f42] [&_h1]:m-[11px_0_12px] [&_p]:text-[13px] [&_p]:leading-[1.85] [&_p]:text-[#899891] small-tablet:[&_h1]:text-[30px] tiny-phone:[&_h1]:text-[28px] dark:[&_h1]:text-[#e2eee9] dark:[&_p]:text-[#a1b8ae] dark:[&_.care-eyebrow]:text-[#8fc0af]"><span class="auth-heading-icon grid place-items-center w-[49px] h-[49px] bg-[#e9f5ef] [border:1px_solid_#dceddf] rounded-[14px] text-[#268f77] mb-[25px] [&_.care-icon]:w-[24px] [&_.care-icon]:h-[24px] small-tablet:w-[43px] small-tablet:h-[43px] small-tablet:mb-[20px] dark:bg-[#1b3b37] dark:border-[#365b4e] dark:text-[#a0d9bf]"><x-care-icon name="shield" /></span><span
            class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">LET’S GET YOU BACK IN</span>
        <h1>Forgot your password?</h1>
        <p>It happens. Enter your account email and we’ll send you a link to choose a new password.</p>
    </div>
    @if (session('status'))
        <div class="auth-status [border:1px_solid_#cce8d9] bg-[#ecf8f0] p-[14px_16px] rounded-[8px] text-[12px] leading-[1.8] text-[#358462] mb-[22px] dark:bg-[#1c3e30] dark:border-[#396647] dark:text-[#a0e2b6]" role="status">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" class="auth-form flex flex-col gap-[20px]">
        @csrf
        <x-auth-field name="email" label="Email address" type="email" :value="old('email')" autocomplete="email"
            placeholder="you@example.com" :autofocus="true" />
        <button type="submit" class="auth-submit w-full flex items-center justify-center gap-[16px] p-[15px_17px] rounded-[8px] font-semibold text-[12px] text-[#fff] bg-[#108c78] shadow-[0_5px_12px_#108c7815] min-h-[49px] [&:hover]:bg-[#097762] [&:hover]:shadow-[0_6px_16px_#108c7830] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[17px] [&_.care-icon]:h-[17px]">Send reset link <x-care-icon name="arrow" /></button>
    </form>
    <div class="auth-switch [&>a]:text-[#118773] [&>a]:font-[650] [&>button]:text-[#118773] [&>button]:font-[650] mt-[26px] text-center text-[#8b9992] text-[12px] [&_a]:ml-[4px] [&_a:hover]:underline [&_a_span]:ml-[4px] tiny-phone:text-[11px] dark:text-[#a1b8ae] dark:[&>a]:text-[#73d8b9] dark:[&>button]:text-[#73d8b9]"><a href="{{ route('login') }}">← Back to login</a></div>
</x-guest-layout>
