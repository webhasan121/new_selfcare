<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Self-Care · {{ config('app.name') }}</title>
    <x-theme-init />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="[&_[x-cloak]]:!hidden care-app m-[0] bg-[#f5f7f9] text-[#253647] [font-family:Inter,_Figtree,_ui-sans-serif,_system-ui,_sans-serif] text-[14px] antialiased [&_*]:box-border [&_a]:[transition:background_0.18s,_color_0.18s,_box-shadow_0.18s,_transform_0.18s] [&_button]:[transition:background_0.18s,_color_0.18s,_box-shadow_0.18s,_transform_0.18s] [&_:focus-visible]:[outline:3px_solid_#16b8a6] [&_:focus-visible]:outline-offset-[4px] motion-reduce:[&_*]:![transition:none] motion-reduce:[&_*]:![scroll-behavior:auto] dark:bg-[#0b151e] dark:text-[#dce7ec]" x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false">
    <a class="care-skip fixed top-[-100px] left-[16px] z-[100] bg-[white] p-[12px] [&:focus]:top-[12px] dark:bg-[#172f3c] dark:text-[white]" href="#main-content">Skip to content</a>
    <button x-cloak x-show="sidebarOpen" class="care-backdrop hidden tablet:block tablet:fixed tablet:[inset:0] tablet:bg-[#102a3580] tablet:z-[35] tablet:[backdrop-filter:blur(2px)]" @click="sidebarOpen = false"
        aria-label="Close navigation"></button>
    @include('layouts.navigation')
    <div class="care-workspace ml-[248px] min-h-screen flex flex-col below-xl:ml-[220px] tablet:ml-[0]">
        <header class="care-topbar h-[87px] [border-bottom:1px_solid_#e6eaed] bg-[#fff] flex items-center justify-between p-[0_38px] gap-[20px] below-xl:p-[0_25px] tablet:h-[75px] tablet:p-[0_22px] tablet:gap-[8px] phone:p-[0_14px] phone:h-[69px] dark:bg-[#12212d] dark:border-[#2b3b49] small-phone:gap-[4px] small-phone:[padding-inline:10px]">
            <div class="care-topbar-title text-[12px] text-[#89939e] flex items-center gap-[12px] [&_strong]:font-[550] [&_strong]:text-[#34444c] below-xl:[&_>_span]:hidden tablet:shrink-0 dark:[&_strong]:text-[#e0eaf0]">
                <button class="care-icon-button w-[36px] h-[36px] grid place-items-center text-[#667b86] rounded-[9px] [&:hover]:bg-[#f1f5f5] phone:w-[31px] dark:text-[#a6bbc8] dark:[&:hover]:bg-[#263b49] dark:[&:hover]:text-[#6be3c9] care-mobile-toggle [&.care-mobile-toggle]:hidden tablet:[&.care-mobile-toggle]:grid" @click="sidebarOpen = !sidebarOpen"
                    :aria-expanded="sidebarOpen" aria-controls="care-sidebar"
                    aria-label="Toggle navigation"><x-care-icon name="menu" /></button>
                <span>My workspace <span class="care-topbar-divider m-[0_13px] text-[#c6cdd2]">/</span> <strong>Self-Care</strong></span>
            </div>
            <div class="care-topbar-actions flex items-center gap-[20px] below-xl:w-full below-xl:justify-end tablet:gap-[10px] phone:gap-[5px] phone:[&_>_.care-dropdown:first-of-type_.care-dropdown-panel]:right-[-50px] small-phone:gap-[3px]">
                @isset($toolbar)
                    {{ $toolbar }}
                @endisset
                <x-theme-toggle />
                <div class="care-dropdown relative" x-data="{ open: false }" @click.outside="open = false"
                    @keydown.escape.window="open = false">
                    <button class="care-icon-button w-[36px] h-[36px] grid place-items-center text-[#667b86] rounded-[9px] [&:hover]:bg-[#f1f5f5] phone:w-[31px] dark:text-[#a6bbc8] dark:[&:hover]:bg-[#263b49] dark:[&:hover]:text-[#6be3c9]" @click="open = !open" :aria-expanded="open"
                        aria-label="Notifications"><x-care-icon name="bell" /></button>
                    <div x-cloak x-show="open" class="care-dropdown-panel absolute right-[0] top-[calc(100%_+_14px)] w-[265px] bg-[white] shadow-[0_16px_50px_#112b3520] [border:1px_solid_#e5ebeb] rounded-[12px] p-[18px] z-[45] [&_p]:text-[#6c7c85] [&_p]:text-[12px] [&_p]:leading-[1.7] [&_p]:mt-[9px] [&_a]:block [&_a]:p-[11px] [&_a]:w-full [&_a]:text-left [&_a]:rounded-[6px] [&_form_button]:block [&_form_button]:p-[11px] [&_form_button]:w-full [&_form_button]:text-left [&_form_button]:rounded-[6px] [&_a:hover]:bg-[#edf7f4] [&_form_button:hover]:bg-[#edf7f4] phone:w-[240px] dark:bg-[#192b39] dark:border-[#354957] dark:shadow-[0_18px_50px_#0007] dark:[&_a:hover]:bg-[#28443e] dark:[&_form_button:hover]:bg-[#28443e] dark:[&_p]:text-[#a4b7c3]"><strong>Notifications</strong>
                        <p>Bill reminders and service updates will appear here when notifications are available.</p>
                    </div>
                </div>
                <div class="care-dropdown relative" x-data="{ open: false }" @click.outside="open = false"
                    @keydown.escape.window="open = false">
                    <button class="care-account-trigger flex items-center gap-[10px] text-left [border-left:1px_solid_#e7eced] pl-[20px] [&_>_.care-icon]:w-[14px] tablet:pl-[12px] phone:[&_>_.care-icon]:hidden phone:pl-[9px] dark:border-[#30424e] small-phone:pl-[6px]" @click="open = !open" :aria-expanded="open"
                        aria-label="Account menu">
                        <span class="care-avatar w-[37px] h-[37px] grid place-items-center rounded-full bg-[#e4f3ee] text-[#228976] font-bold phone:w-[31px] phone:h-[31px] dark:bg-[#1d443f] dark:text-[#82dfc7]">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="care-account-name text-[12px] font-[650] max-w-[135px] overflow-hidden text-ellipsis whitespace-nowrap [&_small]:block [&_small]:text-[10px] [&_small]:font-normal [&_small]:text-[#88949d] [&_small]:mt-[3px] phone:hidden dark:text-[#e0eaf0]">{{ auth()->user()->name }}<small>Personal account</small></span>
                        <x-care-icon name="chevron" />
                    </button>
                    <div x-cloak x-show="open" class="care-dropdown-panel absolute right-[0] top-[calc(100%_+_14px)] w-[265px] bg-[white] shadow-[0_16px_50px_#112b3520] [border:1px_solid_#e5ebeb] rounded-[12px] p-[18px] z-[45] [&_p]:text-[#6c7c85] [&_p]:text-[12px] [&_p]:leading-[1.7] [&_p]:mt-[9px] [&_a]:block [&_a]:p-[11px] [&_a]:w-full [&_a]:text-left [&_a]:rounded-[6px] [&_form_button]:block [&_form_button]:p-[11px] [&_form_button]:w-full [&_form_button]:text-left [&_form_button]:rounded-[6px] [&_a:hover]:bg-[#edf7f4] [&_form_button:hover]:bg-[#edf7f4] phone:w-[240px] dark:bg-[#192b39] dark:border-[#354957] dark:shadow-[0_18px_50px_#0007] dark:[&_a:hover]:bg-[#28443e] dark:[&_form_button:hover]:bg-[#28443e] dark:[&_p]:text-[#a4b7c3]">
                        <a href="{{ route('profile.edit') }}">My profile & settings</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Log out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <main id="main-content" class="care-main p-[34px_38px_45px] w-full m-[0_auto] flex-1 wide:pt-[45px] below-xl:p-[28px_25px] tablet:p-[28px_22px] phone:p-[25px_16px] dark:[&_input:focus]:bg-[#17323b] dark:[&_input:focus]:text-[#edf5f7] dark:[&_input:focus]:border-[#5accb5] dark:[&_textarea:focus]:bg-[#17323b] dark:[&_textarea:focus]:text-[#edf5f7] dark:[&_textarea:focus]:border-[#5accb5] dark:[&_select:focus]:bg-[#17323b] dark:[&_select:focus]:text-[#edf5f7] dark:[&_select:focus]:border-[#5accb5] dark:[&_input::placeholder]:text-[#8ca3b3] dark:[&_textarea::placeholder]:text-[#8ca3b3]">
            <x-care.feedback />
            @isset($header)
                <div class="care-page-heading mb-[20px]">{{ $header }}</div>
            @endisset
            {{ $slot }}
        </main>
        <footer class="care-footer flex justify-between gap-[15px] p-[20px_38px_27px] text-[10px] text-[#91a1a7] [&_>_span:last-child]:flex [&_>_span:last-child]:gap-[6px] [&_>_span:last-child]:items-center [&_.care-icon]:w-[13px] [&_.care-icon]:h-[13px] [&_>_span_>_span]:m-[0_8px] phone:p-[12px_20px_24px] phone:text-[9px] phone:[&_>_span:last-child]:hidden dark:text-[#8faab9]"><span>Self-Care <span>·</span> Your connection, in your
                control.</span><span><x-care-icon name="shield" /> Personal account portal</span></footer>
    </div>
</body>

</html>
