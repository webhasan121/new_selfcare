@props(['name' => 'grid'])
@php
$paths = [
'grid' => 'M3 3h7v7H3z M14 3h7v7h-7z M3 14h7v7H3z M14 14h7v7h-7z',
'wifi' => 'M2 8a16 16 0 0 1 20 0 M5 12a11 11 0 0 1 14 0 M8.5 16a5.5 5.5 0 0 1 7 0 M12 20h.01',
'bill' => 'M6 3h12v18l-3-2-3 2-3-2-3 2V3z M9 8h6 M9 12h6',
'box' => 'm12 3 9 5-9 5-9-5 9-5z M3 8v9l9 5 9-5V8 M12 13v9',
'chart' => 'M4 3v17h17 M8 15l4-5 4 2 5-7',
'help' => 'M4 13v-1a8 8 0 0 1 16 0v1 M4 12H2v6h4v-6H4 M20 12h2v6h-4v-6h2 M20 18v3h-7',
'user' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0 M4 21v-2a8 8 0 0 1 16 0v2',
'arrow' => 'M5 12h14 M13 6l6 6-6 6',
'logout' => 'M9 4H4v16h5 M9 12h12 M16 7l5 5-5 5',
'bell' => 'M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9 M10 21h4',
'menu' => 'M4 6h16 M4 12h16 M4 18h16',
'close' => 'm6 6 12 12 M6 18 18 6',
'check' => 'm5 12 4 4L19 6',
'home' => 'm3 10 9-7 9 7 M5 9v12h14V9 M9 21v-8h6v8',
'clock' => 'M12 8v5l3 2 M22 12a10 10 0 1 1-20 0 10 10 0 0 1 20 0',
'chevron' => 'm8 10 4 4 4-4',
'shield' => 'm12 3 8 3v6c0 5-8 9-8 9s-8-4-8-9V6l8-3z m-4 9 3 3 5-6',
];
@endphp
<svg {{ $attributes->merge(['class' => 'care-icon w-[21px] h-[21px] shrink-0']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $paths[$name] ?? $paths['grid'] }}"/></svg>

