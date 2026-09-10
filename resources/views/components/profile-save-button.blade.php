<button type="submit" {{ $attributes->class('inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-teal-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-500') }}>
    <x-care-icon name="check" class="!h-4 !w-4" /> {{ $slot }}
</button>
