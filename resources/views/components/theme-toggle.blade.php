<button type="button" class="care-icon-button w-[36px] h-[36px] grid place-items-center text-[#667b86] rounded-[9px] [&:hover]:bg-[#f1f5f5] phone:w-[31px] dark:text-[#a6bbc8] dark:[&:hover]:bg-[#263b49] dark:[&:hover]:text-[#6be3c9] care-theme-toggle shrink-0 dark:text-[#f2d38a]" x-data="{ dark: document.documentElement.classList.contains('dark') }"
    @care-theme.window="dark = $event.detail" @click="window.careTheme.toggle()"
    :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
    :title="dark ? 'Switch to light mode' : 'Switch to dark mode'" :aria-pressed="dark"
    aria-label="Toggle dark and light mode">
    <svg class="care-icon w-[21px] h-[21px] shrink-0 theme-moon dark:[&.theme-moon]:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.5 13A8.5 8.5 0 0 1 11 3.5 8.5 8.5 0 1 0 20.5 13Z"/></svg>
    <svg class="care-icon w-[21px] h-[21px] shrink-0 theme-sun [&.theme-sun]:hidden dark:[&.theme-sun]:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M2 12h2m16 0h2M5 5l1.5 1.5m11 11L19 19M5 19l1.5-1.5m11-11L19 5"/></svg>
</button>
