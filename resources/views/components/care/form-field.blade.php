@props(['name', 'label', 'type' => 'text', 'value' => '', 'options' => [], 'hint' => null, 'placeholder' => null, 'required' => true, 'step' => '1'])
@php
$inputClass = 'block w-full rounded-xl border border-slate-300 dark:border-[#496172] bg-slate-50 dark:bg-[#142532] px-4 py-3.5 text-sm font-medium text-slate-800 dark:text-[#e0ebf2] shadow-sm placeholder:font-normal placeholder:text-slate-400 hover:border-slate-400 focus:border-teal-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-600/20';
@endphp
<div class="{{ $type === 'textarea' ? 'sm:col-span-2' : '' }}">
    <label for="{{ $name }}" class="mb-2.5 flex items-center gap-1 text-sm font-bold text-slate-700 dark:text-[#e0ebf2]">{{ $label }} @if($required)<span class="text-teal-700 dark:text-[#8addc8]" aria-hidden="true">*</span>@else<span class="ml-1 text-xs font-normal text-slate-400 dark:text-[#b3c6d3]">(optional)</span>@endif</label>
    @if($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="4" placeholder="{{ $placeholder ?? 'Enter '.strtolower($label) }}" @required($required) aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}" aria-describedby="{{ $name }}-help" class="{{ $inputClass }}">{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" @required($required) aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}" aria-describedby="{{ $name }}-help" class="{{ $inputClass }}">
            <option value="">Choose {{ strtolower($label) }}</option>
            @foreach($options as $key => $option)<option value="{{ $key }}" @selected((string) old($name, $value) === (string) $key)>{{ $option }}</option>@endforeach
        </select>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $type === 'password' ? '' : old($name, $value) }}" @if($type === 'password') autocomplete="new-password" @endif placeholder="{{ $placeholder ?? 'Enter '.strtolower($label) }}" @if($type === 'number') step="{{ $step }}" min="0" @endif @required($required) aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}" aria-describedby="{{ $name }}-help" class="{{ $inputClass }}">
    @endif
    <div id="{{ $name }}-help">@if($hint)<p class="mt-2 text-xs leading-5 text-slate-500 dark:text-[#b3c6d3]">{{ $hint }}</p>@endif
    @error($name)<p class="mt-2 text-xs font-semibold text-red-700 dark:text-[#ffb4b4]">{{ $message }}</p>@enderror</div>
</div>

