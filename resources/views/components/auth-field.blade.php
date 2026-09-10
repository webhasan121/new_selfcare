@props(['name', 'label', 'type' => 'text', 'value' => null, 'autocomplete' => null, 'placeholder' => '', 'autofocus' => false])
<div class="auth-field min-w-0 [&>label]:block [&>label]:text-[12px] [&>label]:font-semibold [&>label]:text-[#415a56] [&>label]:mb-[8px] [&[x-data]_input]:pr-[58px] dark:[&>label]:text-[#e2eee9]" @if($type === 'password') x-data="{ visible: false }" @endif>
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="auth-input-wrap relative [&_input]:w-full [&_input]:[border:1px_solid_#dce5df] [&_input]:rounded-[8px] [&_input]:bg-[#fff] [&_input]:text-[#28423b] [&_input]:p-[13px_15px] [&_input]:text-[13px] [&_input]:leading-[22px] [&_input]:shadow-[0_2px_3px_#264d3a02] [&_input]:[transition:border-color_.2s,box-shadow_.2s] [&_input::placeholder]:text-[#a6b0ab] [&_input::placeholder]:text-[12px] [&_input:focus]:border-[#149780] [&_input:focus]:outline-none [&_input:focus]:shadow-[0_0_0_3px_#14978012] [&_input[aria-invalid=true]]:border-[#cf7878] dark:[&_input]:bg-[#182d36] dark:[&_input]:text-[#e2ece8] dark:[&_input]:border-[#486258] dark:[&_input::placeholder]:text-[#8da79c] dark:[&_input:focus]:bg-[#1b333b] dark:[&_input:focus]:border-[#4dc5aa] dark:[&_input:focus]:shadow-[0_0_0_3px_#4dc5aa20] dark:[&_input[aria-invalid=true]]:border-[#ef9292]">
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            @if($type === 'password') :type="visible ? 'text' : 'password'" @else value="{{ $value }}" @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            placeholder="{{ $placeholder }}" required @if($autofocus) autofocus @endif
            @if($type === 'tel') maxlength="20" @endif
            aria-invalid="{{ $errors->has($name) ? 'true' : 'false' }}"
            @if($errors->has($name)) aria-describedby="{{ $name }}-error" @endif>
        @if($type === 'password')
            <button type="button" class="auth-reveal absolute right-[12px] top-[50%] [transform:translateY(-50%)] text-[10px] font-[650] text-[#609385] p-[6px_3px] [&:hover]:text-[#087e69] dark:text-[#73d8b9]" @click="visible = !visible" :aria-pressed="visible" aria-controls="{{ $name }}" aria-label="Toggle {{ strtolower($label) }} visibility" x-cloak x-text="visible ? 'Hide' : 'Show'">Show</button>
        @endif
    </div>
    @if($errors->has($name))<ul id="{{ $name }}-error" class="auth-error text-[11px] text-[#b34b4b] leading-[1.7] mt-[7px] dark:text-[#ffa9a9]" role="alert">@foreach($errors->get($name) as $message)<li>{{ $message }}</li>@endforeach</ul>@endif
</div>
