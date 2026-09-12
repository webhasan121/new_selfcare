@php
    $menu = [
        ['overview', 'grid', 'Overview'],
        ['connections', 'wifi', 'My connections'],
        ['billing', 'bill', 'Bills & payments'],
        ['packages', 'box', 'Packages'],
        ['usage', 'chart', 'Usage history'],
        ['support', 'help', 'Help & support'],
    ];
    $currentSection = request()->routeIs('dashboard', 'dashboard.*') ? 'overview' : explode('.', request()->route()->getName())[0];
@endphp
<aside id="care-sidebar" class="care-sidebar w-[248px] fixed [inset:0_auto_0_0] bg-[#112b35] text-[#adc1c8] flex flex-col p-[34px_20px_20px] z-[40] overflow-y-auto below-xl:w-[220px] below-xl:[padding-inline:15px] tablet:[transform:translateX(-100%)] tablet:[transition:transform_0.2s] tablet:w-[248px] tablet:[&.is-open]:[transform:translateX(0)] dark:bg-[#0c222d] dark:[border-right:1px_solid_#263b47]" :class="{ 'is-open': sidebarOpen }" aria-label="Main navigation"
    @click="if ($event.target.closest('a')) sidebarOpen = false">
    <a class="care-brand flex items-center gap-[11px] text-[white] text-[29px] font-[750] tracking-[-1.2px] m-[0_10px_48px] leading-[1] [&_small]:block [&_small]:text-[8px] [&_small]:tracking-[3px] [&_small]:font-medium [&_small]:text-[#8eabb4] [&_small]:mt-[10px]" href="{{ route('dashboard') }}"><span class="care-brand-mark w-[40px] h-[44px] rounded-[13px] bg-[#21bea6] grid place-items-center text-[#0c3236] [&_.care-icon]:w-[28px] [&_.care-icon]:h-[28px]"><x-care-icon
                name="wifi" /></span><span>self<span class="care-brand-light font-[350]">care</span><small>STAY
                CONNECTED</small></span></a>
    <div class="care-sidebar-label text-[9px] tracking-[2px] font-bold m-[0_15px_17px] text-[#79959f]">YOUR WORKSPACE</div>
    <nav class="care-nav flex flex-col gap-[7px] [&_>_a]:flex [&_>_a]:items-center [&_>_a]:gap-[13px] [&_>_a]:p-[13px_15px] [&_>_a]:rounded-[9px] [&_>_a]:text-[13px] [&_>_a]:font-[550] [&_>_a:hover]:bg-[#1c3b45] [&_>_a:hover]:text-[white] [&_>_a.is-active]:bg-[#204a50] [&_>_a.is-active]:text-[#61e0c8]">
        @php($menuPermissions = ['overview' => 'dashboard.view', 'connections' => 'connection.view', 'billing' => 'billing.view', 'packages' => 'package.view', 'usage' => 'usage.view', 'support' => 'support.view'])
        @foreach ($menu as [$key, $icon, $label])
            @can($menuPermissions[$key])
            <a href="{{ route($key === 'overview' ? 'dashboard' : $key . '.index', array_filter(['connection' => request('connection')])) }}"
                class="{{ $currentSection === $key ? 'is-active' : '' }}"
                @if ($currentSection === $key) aria-current="page" @endif><x-care-icon
                    :name="$icon" /><span>{{ $label }}</span>
                @if ($currentSection === $key)
                    <span class="care-active-dot w-[6px] h-[6px] rounded-full bg-[#58dfc3] ml-[auto]"></span>
                @endif
            </a>
            @endcan
        @endforeach
        @can('viewAny', \App\Models\Setting::class)
            <a href="{{ route('settings.index') }}" class="{{ $currentSection === 'settings' ? 'is-active' : '' }}"
                @if ($currentSection === 'settings') aria-current="page" @endif>
                <x-care-icon name="settings" /><span>Settings</span>
                @if ($currentSection === 'settings')
                    <span class="care-active-dot w-[6px] h-[6px] rounded-full bg-[#58dfc3] ml-[auto]"></span>
                @endif
            </a>
        @endcan
        @can('viewAny', \Spatie\Permission\Models\Role::class)
            <a href="{{ route('roles.index') }}" class="{{ $currentSection === 'roles' ? 'is-active' : '' }}"
                @if ($currentSection === 'roles') aria-current="page" @endif>
                <x-care-icon name="shield" /><span>Roles</span>
                @if ($currentSection === 'roles')
                    <span class="care-active-dot w-[6px] h-[6px] rounded-full bg-[#58dfc3] ml-[auto]"></span>
                @endif
            </a>
        @endcan
        @can('viewAny', \Spatie\Permission\Models\Permission::class)
            <a href="{{ route('permissions.index') }}" class="{{ $currentSection === 'permissions' ? 'is-active' : '' }}"
                @if ($currentSection === 'permissions') aria-current="page" @endif>
                <x-care-icon name="key" /><span>Permissions</span>
                @if ($currentSection === 'permissions')
                    <span class="care-active-dot w-[6px] h-[6px] rounded-full bg-[#58dfc3] ml-[auto]"></span>
                @endif
            </a>
        @endcan
        @can('viewAny', \App\Models\User::class)
            <a href="{{ route('users.index') }}" class="{{ $currentSection === 'users' ? 'is-active' : '' }}"
                @if ($currentSection === 'users') aria-current="page" @endif>
                <x-care-icon name="user" /><span>Users</span>
                @if ($currentSection === 'users')
                    <span class="care-active-dot w-[6px] h-[6px] rounded-full bg-[#58dfc3] ml-[auto]"></span>
                @endif
            </a>
        @endcan
        <div class="care-sidebar-rule h-[1px] bg-[#29404a] m-[18px_12px]"></div>
        @can('profile.view')<a href="{{ route('profile.edit') }}" class="{{ $currentSection === 'profile' ? 'is-active' : '' }}"
            @if ($currentSection === 'profile') aria-current="page" @endif><x-care-icon name="user" /><span>My
                profile</span></a>@endcan
    </nav>
    <div class="care-sidebar-bottom mt-[auto] pt-[42px]">
        <div class="care-help-card [background:linear-gradient(135deg,_#22434a,_#19363f)] [border:1px_solid_#31505a] rounded-[14px] p-[19px] [&_strong]:block [&_strong]:text-[#e6f2f1] [&_strong]:text-[14px] [&_p]:text-[11px] [&_p]:leading-[1.8] [&_p]:m-[8px_0_17px] [&_p]:text-[#9fb9bf] [&_a]:flex [&_a]:items-center [&_a]:justify-between [&_a]:text-[#82ddce] [&_a]:text-[12px] [&_a]:font-semibold [&_.care-icon]:w-[18px]"><span class="care-help-symbol text-[#68d6c4] block mb-[12px]"><x-care-icon name="help" /></span><strong>A little
                help?</strong>
            <p>Find answers and keep your connection running smoothly.</p><a href="{{ route('support.index') }}">Visit
                help center <x-care-icon name="arrow" /></a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="care-sidebar-logout [&_button]:flex [&_button]:gap-[12px] [&_button]:items-center [&_button]:p-[22px_14px_15px] [&_button]:text-[#a5bac1] [&_button]:text-[13px] [&_button]:w-full [&_button]:text-left">@csrf<button
                type="submit"><x-care-icon name="logout" /> Log out</button></form>
        <div class="care-sidebar-caption text-[9px] text-[#718d97] text-center pt-[6px]">Made for your everyday connection.</div>
    </div>
</aside>
