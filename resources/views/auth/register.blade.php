<x-guest-layout>
    <x-slot name="title">Create an account</x-slot>
    <div class="auth-heading mb-[30px] [&_.care-eyebrow]:block [&_.care-eyebrow]:text-[#619082] [&_.care-eyebrow]:tracking-[1.7px] [&_.care-eyebrow]:text-[9px] [&_h1]:text-[34px] [&_h1]:tracking-[-1.2px] [&_h1]:font-bold [&_h1]:leading-[1.22] [&_h1]:text-[#213f42] [&_h1]:m-[11px_0_12px] [&_p]:text-[13px] [&_p]:leading-[1.85] [&_p]:text-[#899891] small-tablet:[&_h1]:text-[30px] tiny-phone:[&_h1]:text-[28px] dark:[&_h1]:text-[#e2eee9] dark:[&_p]:text-[#a1b8ae] dark:[&_.care-eyebrow]:text-[#8fc0af] auth-heading-compact [&_h1]:text-[30px] [&.auth-heading-compact]:mb-[25px] small-tablet:[&_h1]:text-[28px]"><span class="care-eyebrow text-[9px] tracking-[1.7px] font-[750] text-[#6d8991] phone:text-[8px] dark:text-[#8faab9]">A MORE CONNECTED EVERYDAY</span>
        <h1>Make yourself at home.</h1>
        <p>Create your account. Keep everything together.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="auth-form flex flex-col gap-[20px]">
        @csrf
        <x-auth-field name="name" label="Full name" :value="old('name')" autocomplete="name" placeholder="Your full name"
            :autofocus="true" />
        <x-auth-field name="email" label="Email address" type="email" :value="old('email')" autocomplete="email"
            placeholder="you@example.com" />
        <x-auth-field name="contact" label="Mobile number" type="tel" :value="old('contact')" autocomplete="tel"
            placeholder="01XXXXXXXXX" />
        <div class="auth-field-grid grid grid-cols-[1fr_1fr] gap-[14px] tiny-phone:grid-cols-[1fr] tiny-phone:gap-[20px]">
            <x-auth-field name="password" label="Password" type="password" autocomplete="new-password"
                placeholder="Create password" />
            <x-auth-field name="password_confirmation" label="Confirm password" type="password"
                autocomplete="new-password" placeholder="Repeat password" />
        </div>
        <button type="submit" class="auth-submit w-full flex items-center justify-center gap-[16px] p-[15px_17px] rounded-[8px] font-semibold text-[12px] text-[#fff] bg-[#108c78] shadow-[0_5px_12px_#108c7815] min-h-[49px] [&:hover]:bg-[#097762] [&:hover]:shadow-[0_6px_16px_#108c7830] [&:hover]:[transform:translateY(-1px)] [&_.care-icon]:w-[17px] [&_.care-icon]:h-[17px]">Create my account <x-care-icon name="arrow" /></button>
    </form>
    <div class="auth-switch [&>a]:text-[#118773] [&>a]:font-[650] [&>button]:text-[#118773] [&>button]:font-[650] mt-[26px] text-center text-[#8b9992] text-[12px] [&_a]:ml-[4px] [&_a:hover]:underline [&_a_span]:ml-[4px] tiny-phone:text-[11px] dark:text-[#a1b8ae] dark:[&>a]:text-[#73d8b9] dark:[&>button]:text-[#73d8b9]">Already have an account? <a href="{{ route('login') }}">Log in <span>↗</span></a></div>
    <div class="auth-footnote flex items-center justify-center gap-[7px] [border-top:1px_solid_#e6ece7] mt-[30px] pt-[22px] text-[#95a69c] text-[10px] [&_.care-icon]:w-[14px] [&_.care-icon]:h-[14px] [&_.care-icon]:shrink-0 tiny-phone:text-[9px] dark:border-[#2c453a] dark:text-[#94b3a1]"><x-care-icon name="wifi" /><span>Link your services with your provider after signing
            up.</span></div>
</x-guest-layout>
