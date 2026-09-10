<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Welcome' }} · Self-Care</title>
    <x-theme-init />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="[&_[x-cloak]]:!hidden care-app m-[0] bg-[#f5f7f9] text-[#253647] [font-family:Inter,_Figtree,_ui-sans-serif,_system-ui,_sans-serif] text-[14px] antialiased [&_*]:box-border [&_a]:[transition:background_0.18s,_color_0.18s,_box-shadow_0.18s,_transform_0.18s] [&_button]:[transition:background_0.18s,_color_0.18s,_box-shadow_0.18s,_transform_0.18s] [&_:focus-visible]:[outline:3px_solid_#16b8a6] [&_:focus-visible]:outline-offset-[4px] motion-reduce:[&_*]:![transition:none] motion-reduce:[&_*]:![scroll-behavior:auto] dark:bg-[#0b151e] dark:text-[#dce7ec] auth-page [&.auth-page]:bg-[#f8faf9]">
    <main class="auth-shell min-h-screen grid grid-cols-[minmax(400px,46%)_1fr] below-lg:grid-cols-[42%_58%] small-tablet:flex small-tablet:flex-col">
        <aside class="auth-story relative [background:radial-gradient(ellipse_at_10%_75%,#15534f_0,transparent_60%),linear-gradient(145deg,#112d37,#123c40)] text-[#fff] p-[45px_55px_28px] flex flex-col overflow-hidden [&_.care-brand]:m-[0] [&_.care-brand]:text-[31px] [&_.care-brand]:w-[fit-content] [&_.care-brand_small]:text-[8px] [&_h2]:text-[clamp(36px,3.6vw,55px)] [&_h2]:leading-[1.18] [&_h2]:tracking-[-2px] [&_h2]:font-[650] [&_h2]:m-[23px_0_21px] [&_h2_em]:not-italic [&_h2_em]:text-[#6bdec1] wide:pl-[85px] wide:pr-[70px] below-lg:p-[35px_30px_25px] below-lg:[&_h2]:text-[38px] small-tablet:p-[24px_25px] small-tablet:[background:linear-gradient(115deg,#12333b,#1a544e)] small-tablet:[&_.care-brand]:text-[27px] small-tablet:[&_.care-brand-mark]:w-[36px] small-tablet:[&_.care-brand-mark]:h-[38px] small-tablet:[&_.care-brand_small]:text-[7px] small-tablet:[&_.care-brand_small]:mt-[7px]" aria-label="About Self-Care">
            <a class="care-brand flex items-center gap-[11px] text-[white] text-[29px] font-[750] tracking-[-1.2px] m-[0_10px_48px] leading-[1] [&_small]:block [&_small]:text-[8px] [&_small]:tracking-[3px] [&_small]:font-medium [&_small]:text-[#8eabb4] [&_small]:mt-[10px]" href="{{ url('/') }}"><span class="care-brand-mark w-[40px] h-[44px] rounded-[13px] bg-[#21bea6] grid place-items-center text-[#0c3236] [&_.care-icon]:w-[28px] [&_.care-icon]:h-[28px]"><x-care-icon
                        name="wifi" /></span><span>self<span class="care-brand-light font-[350]">care</span><small>STAY
                        CONNECTED</small></span></a>
            <div class="auth-story-content m-[auto_0] p-[48px_0_30px] relative z-[1] [&>p]:text-[#a5bfc1] [&>p]:leading-[1.95] [&>p]:text-[13px] wide:max-w-[500px] below-lg:[&>p]:text-[12px] small-tablet:hidden">
                <span class="auth-kicker text-[9px] tracking-[2px] font-[650] text-[#7dc5b9] flex items-center gap-[9px] [&>span]:w-[6px] [&>span]:h-[6px] [&>span]:rounded-full [&>span]:bg-[#50d7b6]"><span></span> YOUR WORLD. CONNECTED.</span>
                <h2>One account.<br>Every connection.<br><em>All yours.</em></h2>
                <p>Home, office and everything in between.<br>A simpler way to look after your internet.</p>
                <div class="auth-illustration h-[225px] relative m-[18px_0_12px] max-w-[390px] wide:h-[270px] below-lg:h-[230px]" aria-hidden="true">
                    <div class="auth-ring absolute [border:1px_solid_#75c3b51c] rounded-full left-[50%] top-[50%] [transform:translate(-50%,-50%)] auth-ring-one w-[195px] h-[195px]"></div>
                    <div class="auth-ring absolute [border:1px_solid_#75c3b51c] rounded-full left-[50%] top-[50%] [transform:translate(-50%,-50%)] auth-ring-two w-[285px] h-[285px]"></div>
                    <div class="auth-hub absolute left-[45%] top-[39%] w-[72px] h-[72px] rounded-[21px] [rotate:-12deg] grid place-items-center [border:1px_solid_#73c9b84a] [background:linear-gradient(135deg,#2f776d,#20524f)] shadow-[0_15px_30px_#062b3830] text-[#9cebd3] [&_.care-icon]:w-[40px] [&_.care-icon]:h-[40px]"><x-care-icon name="wifi" /></div>
                    <div class="auth-node absolute flex gap-[12px] items-center bg-[#ffffff0c] [backdrop-filter:blur(8px)] [border:1px_solid_#9ccec429] p-[14px_16px] rounded-[12px] shadow-[0_12px_35px_#07232d30] [&>span]:w-[34px] [&>span]:h-[34px] [&>span]:rounded-[10px] [&>span]:bg-[#77d6bc15] [&>span]:grid [&>span]:place-items-center [&>span]:text-[#8cd9c4] [&>div]:text-[11px] [&>div]:font-semibold [&>div]:text-[#e0f2ed] [&_small]:block [&_small]:text-[9px] [&_small]:text-[#94b8b0] [&_small]:font-normal [&_small]:mt-[5px] [&_i]:w-[5px] [&_i]:h-[5px] [&_i]:rounded-full [&_i]:bg-[#76d6ad] [&_i]:ml-[13px] below-lg:p-[11px] below-lg:gap-[8px] below-lg:[&_small]:text-[8px] below-lg:[&_i]:ml-[3px] auth-node-home left-[0] top-[18px] [rotate:-5deg] below-lg:left-[-7px]"><span><x-care-icon name="home" /></span>
                        <div>Home connection<small>Your everyday essentials</small></div><i></i>
                    </div>
                    <div class="auth-node absolute flex gap-[12px] items-center bg-[#ffffff0c] [backdrop-filter:blur(8px)] [border:1px_solid_#9ccec429] p-[14px_16px] rounded-[12px] shadow-[0_12px_35px_#07232d30] [&>span]:w-[34px] [&>span]:h-[34px] [&>span]:rounded-[10px] [&>span]:bg-[#77d6bc15] [&>span]:grid [&>span]:place-items-center [&>span]:text-[#8cd9c4] [&>div]:text-[11px] [&>div]:font-semibold [&>div]:text-[#e0f2ed] [&_small]:block [&_small]:text-[9px] [&_small]:text-[#94b8b0] [&_small]:font-normal [&_small]:mt-[5px] [&_i]:w-[5px] [&_i]:h-[5px] [&_i]:rounded-full [&_i]:bg-[#76d6ad] [&_i]:ml-[13px] below-lg:p-[11px] below-lg:gap-[8px] below-lg:[&_small]:text-[8px] below-lg:[&_i]:ml-[3px] auth-node-office right-[0] bottom-[15px] [rotate:5deg] below-lg:right-[-7px]"><span><x-care-icon name="box" /></span>
                        <div>Office connection<small>Your space to do more</small></div><i></i>
                    </div>
                </div>
                <div class="auth-benefits flex flex-wrap gap-[13px_20px] text-[10px] text-[#b1cbc4] [&>span]:flex [&>span]:gap-[6px] [&>span]:items-center [&_.care-icon]:w-[13px] [&_.care-icon]:h-[13px] [&_.care-icon]:text-[#72c7ad] below-lg:text-[9px] below-lg:gap-[12px]"><span><x-care-icon name="check" /> All your
                        connections</span><span><x-care-icon name="check" /> Bills in one
                        place</span><span><x-care-icon name="check" /> Your account, simplified</span></div>
            </div>
            <div class="auth-story-footer text-[10px] text-[#739f9e] flex items-center gap-[8px] relative z-[1] [&_.care-icon]:w-[15px] [&_.care-icon]:h-[15px] small-tablet:hidden"><x-care-icon name="shield" /> A personal space for your connected life.
            </div>
        </aside>
        <section class="auth-form-side flex flex-col p-[36px_48px_25px] min-w-0 [background:radial-gradient(ellipse_at_100%_0,#eaf5f040,transparent_50%),#fbfcfb] below-lg:p-[30px] small-tablet:p-[22px_25px] small-tablet:flex-1 tiny-phone:[padding-inline:20px] dark:bg-[#101f2a] dark:bg-none">
            <div class="auth-topline flex items-center justify-between gap-[20px] text-[11px] text-[#83928f] [&_a:hover]:text-[#138a78] [&>span]:text-[8px] [&>span]:tracking-[1.6px] [&>span]:text-[#97a59f] below-lg:[&>span]:hidden small-tablet:[&>span]:block small-tablet:[&>span]:text-[7px] tiny-phone:[&>span]:hidden dark:text-[#a1b8ae] dark:[&>span]:text-[#8fc0af]"><a href="{{ url('/') }}">← Back to home</a><span>PERSONAL ACCOUNT
                    PORTAL</span><x-theme-toggle /></div>
            <div class="auth-form-wrap w-full max-w-[415px] m-[auto] p-[45px_0] small-tablet:max-w-[430px] small-tablet:p-[34px_0_40px]">{{ $slot }}</div>
            <footer class="auth-footer text-center text-[#9aaba0] text-[10px] [&_span]:p-[0_8px] small-tablet:pb-[4px] dark:text-[#819f8d]">Self-Care <span>·</span> Your connection, in your control.</footer>
        </section>
    </main>
</body>

</html>
