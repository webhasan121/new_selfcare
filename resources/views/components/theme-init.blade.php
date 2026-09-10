<script>
    (() => {
        const key = 'selfcare.theme';
        const media = window.matchMedia('(prefers-color-scheme: dark)');
        let preference = null;
        try { preference = localStorage.getItem(key); } catch (_) {}
        const apply = () => {
            const dark = preference === 'dark' || (preference !== 'light' && media.matches);
            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
            window.dispatchEvent(new CustomEvent('care-theme', { detail: dark }));
        };
        window.careTheme = {
            toggle() {
                preference = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
                try { localStorage.setItem(key, preference); } catch (_) {}
                apply();
            }
        };
        media.addEventListener('change', apply);
        window.addEventListener('storage', (event) => {
            if (event.key === key || event.key === null) {
                preference = event.newValue;
                apply();
            }
        });
        apply();
    })();
</script>
