@props(['name', 'label', 'id' => null, 'type' => 'text', 'value' => null, 'messages' => []])
@php($fieldId = $id ?? $name)
<div class="min-w-0" @if($type === 'password') x-data="{ visible: false }" @endif>
    <label for="{{ $fieldId }}" class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $label }} <span class="text-teal-600 dark:text-teal-300" aria-hidden="true">*</span></label>
    <div class="relative">
        <input id="{{ $fieldId }}" name="{{ $name }}" type="{{ $type }}"
            @if($type === 'password') :type="visible ? 'text' : 'password'" @else value="{{ $value }}" @endif
            required aria-invalid="{{ count($messages) ? 'true' : 'false' }}"
            @if(count($messages)) aria-describedby="{{ $fieldId }}-error" @endif
            {{ $attributes->class(['block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 dark:border-slate-600 dark:bg-[#10212d] dark:text-slate-100 dark:placeholder:text-slate-500', 'pr-16' => $type === 'password', '!border-red-400' => count($messages)]) }} />
        @if($type === 'password')
            <button type="button" x-cloak @click="visible = !visible" :aria-pressed="visible" aria-controls="{{ $fieldId }}" aria-label="Toggle {{ strtolower($label) }} visibility" class="absolute inset-y-0 right-3 my-auto h-8 rounded px-1 text-xs font-semibold text-teal-700 hover:text-teal-900 dark:text-teal-300 dark:hover:text-teal-200" x-text="visible ? 'Hide' : 'Show'">Show</button>
        @endif
    </div>
    @if(count($messages))
        <ul id="{{ $fieldId }}-error" class="mt-2 space-y-1 text-xs text-red-600 dark:text-red-300" role="alert">
            @foreach($messages as $message)<li>{{ $message }}</li>@endforeach
        </ul>
    @endif
</div>
