<x-guest-layout>
    <x-slot name="title">Reset password</x-slot>
    <div class="auth-heading mb-[30px] [&_.care-eyebrow]:block [&_.care-eyebrow]:text-[#619082] [&_.care-eyebrow]:tracking-[1.7px] [&_.care-eyebrow]:text-[9px] [&_h1]:text-[34px] [&_h1]:tracking-[-1.2px] [&_h1]:font-bold [&_h1]:leading-[1.22] [&_h1]:text-[#213f42] [&_h1]:m-[11px_0_12px] [&_p]:text-[13px] [&_p]:leading-[1.85] [&_p]:text-[#899891] small-tablet:[&_h1]:text-[30px] tiny-phone:[&_h1]:text-[28px] dark:[&_h1]:text-[#e2eee9] dark:[&_p]:text-[#a1b8ae] dark:[&_.care-eyebrow]:text-[#8fc0af]"><span class="auth-heading-icon grid place-items-center w-[49px] h-[49px] bg-[#e9f5ef] [border:1px_solid_#dceddf] rounded-[14px] text-[#268f77] mb-[25px] [&_.care-icon]:w-[24px] [&_.care-icon]:h-[24px] small-tablet:w-[43px] small-tablet:h-[43px] small-tablet:mb-[20px] dark:bg-[#1b3b37] dark:border-[#365b4e] dark:text-[#a0d9bf]"><x-care-icon name="shield" /></span><span
            class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">A FRESH START</span>
        <h1>Set a new password.</h1>
        <p>Choose a unique password to get back to your account.</p>
    </div>
    <form method="POST" action="{{ route('password.store') }}" class="auth-form flex flex-col gap-[20px]">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <x-auth-field name="email" label="Email address" type="email" :value="old('email', $request->email)" autocomplete="username"
            placeholder="you@example.com" :autofocus="true" />
        <x-auth-field name="password" label="New password" type="password" autocomplete="new-password"
            placeholder="Create a new password" />
        <x-auth-field name="password_confirmation" label="Confirm new password" type="password"
            autocomplete="new-password" placeholder="Repeat your new password" />
        <button type="submit" class="auth-submit w-full flex items-center justify-center gap-[16px] p-[15px_17px] rounded-[8px] font-semibold text-[12px] text-[#fff] bg-[#108c78] shadow-[0_5px_12px_#108c7815] min-h-[49px] [&:hover]:bg-[#097762] [&:hover]:shadow-[0_6px_16px_#108c7830] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[17px] [&_.care-icon]:h-[17px]">Reset password <x-care-icon name="arrow" /></button>
    </form>
    <div class="auth-switch [&>a]:text-[#118773] [&>a]:font-[650] [&>button]:text-[#118773] [&>button]:font-[650] mt-[26px] text-center text-[#8b9992] text-[12px] [&_a]:ml-[4px] [&_a:hover]:underline [&_a_span]:ml-[4px] tiny-phone:text-[11px] dark:text-[#a1b8ae] dark:[&>a]:text-[#73d8b9] dark:[&>button]:text-[#73d8b9]"><a href="{{ route('login') }}">← Back to login</a></div>
</x-guest-layout>
