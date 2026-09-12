@props(['module', 'label', 'mode', 'fields' => [], 'record' => null, 'available' => true, 'icon' => 'grid'])
@php
$indexRoute = $module === 'dashboard' ? 'dashboard' : $module.'.index';
$heading = ['create' => 'New '.$label, 'edit' => 'Edit '.$label, 'show' => $label.' details'][$mode];
$updatePermissions = ['dashboard' => 'dashboard.view', 'connections' => 'connection.update', 'billing' => 'invoice.update', 'usage' => 'usage.view', 'support' => 'support.update'];
$deletePermissions = ['dashboard' => 'dashboard.view', 'connections' => 'connection.delete', 'billing' => 'invoice.update', 'usage' => 'usage.view', 'support' => 'support.delete'];
@endphp
<x-app-layout>
    <div class="w-full">
        <a href="{{ route($indexRoute) }}" class="mb-5 inline-flex items-center gap-2 text-sm font-semibold text-teal-700 dark:text-[#8addc8] hover:text-teal-900"><span aria-hidden="true">←</span> Back to {{ $module === 'billing' ? 'bills & payments' : $module }}</a>
        <div class="mb-6 flex items-center justify-between gap-4">
            <div><p class="mb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-teal-700 dark:text-[#8addc8]">Your personal workspace</p><h1 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-[#e0ebf2] sm:text-3xl">{{ $heading }}</h1><p class="mt-2 text-sm text-slate-500 dark:text-[#b3c6d3]">{{ $mode === 'show' ? 'Review your saved information and manage this record.' : 'Fill in the details below. Fields marked * are required.' }}</p></div>
            <span class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-teal-200 dark:border-[#38645b] bg-teal-50 dark:bg-[#193d39] text-teal-700 dark:text-[#8addc8] sm:flex"><x-care-icon :name="$icon"/></span>
        </div>
        <div class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
            <section class="min-w-0 overflow-hidden rounded-2xl border border-slate-200 dark:border-[#2e4655] bg-white dark:bg-[#142532] shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-200 dark:border-[#2e4655] bg-slate-50/70 dark:bg-[#142532] px-5 py-5 sm:px-7"><span class="flex h-10 w-10 items-center justify-center rounded-xl border border-teal-200 dark:border-[#38645b] bg-teal-50 dark:bg-[#193d39] text-teal-700 dark:text-[#8addc8]"><x-care-icon :name="$icon"/></span><div><h2 class="text-base font-bold text-slate-800 dark:text-[#e0ebf2]">{{ $mode === 'show' ? 'Record overview' : $label.' information' }}</h2><p class="mt-1 text-xs text-slate-500 dark:text-[#b3c6d3]">{{ $mode === 'show' ? 'Details saved to your account' : 'Review the information before saving' }}</p></div></div>
                @if($mode === 'show')
                    <dl class="grid gap-x-8 gap-y-6 p-5 sm:grid-cols-2 sm:p-7">
                        @foreach($fields as $field)
                            <div class="rounded-xl border border-slate-100 dark:border-[#2e4655] bg-slate-50 dark:bg-[#142532] p-4 {{ ($field['type'] ?? '') === 'textarea' ? 'sm:col-span-2' : '' }}">
                                <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-[#b3c6d3]">{{ $field['label'] }}</dt>
                                @if(($field['type'] ?? '') === 'status')
                                    <dd class="mt-3 leading-none"><x-care.status-badge :status="$field['value']" /></dd>
                                @else
                                    <dd class="mt-2 whitespace-pre-line break-words text-sm font-semibold leading-7 text-slate-800 dark:text-[#e0ebf2]">{{ $field['value'] !== null && $field['value'] !== '' ? ($field['options'][$field['value']] ?? $field['value']) : 'Not provided' }}</dd>
                                @endif
                            </div>
                        @endforeach
                    </dl>
                    @if($module === 'usage')<p class="mx-5 mb-6 rounded-xl border border-sky-200 dark:border-[#345b70] bg-sky-50 dark:bg-[#193b50] p-4 text-sm leading-6 text-sky-800 dark:text-[#a2d8f5]">Your report criteria are saved. Network usage measurements are not connected yet.</p>@endif
                @else
                    <form method="POST" action="{{ $mode === 'edit' ? route($module.'.update', $record) : route($module.'.store') }}" class="p-5 sm:p-7" x-data="{ saving: false }" @submit="if (saving) { $event.preventDefault() } else { saving = true }">
                        @csrf
                        @if($mode === 'edit') @method('PUT') @endif
                        <div class="grid gap-x-6 gap-y-6 sm:grid-cols-2">
                            @foreach($fields as $field)<x-care.form-field :name="$field['name']" :label="$field['label']" :type="$field['type'] ?? 'text'" :value="$field['value'] ?? ''" :options="$field['options'] ?? []" :hint="$field['hint'] ?? null" :placeholder="$field['placeholder'] ?? null" :required="$field['required'] ?? true" :step="$field['step'] ?? '1'"/>@endforeach
                        </div>
                        @if($module === 'connections')<p class="mt-6 rounded-xl bg-teal-50 dark:bg-[#193d39] p-4 text-xs leading-6 text-teal-800 dark:text-[#8addc8]">Use the connection credentials supplied by your internet provider.</p>@endif
                        @if($module === 'usage')<p class="mt-6 rounded-xl bg-sky-50 dark:bg-[#193b50] p-4 text-xs leading-6 text-sky-800 dark:text-[#a2d8f5]">Save the connection and date range for your report. Live usage measurements are not available yet.</p>@endif
                        @if($module === 'billing')<p class="mt-6 rounded-xl bg-slate-50 dark:bg-[#142532] p-4 text-xs leading-6 text-slate-600 dark:text-[#b3c6d3]">New invoices start as unpaid. Payment status is managed by the payment workflow.</p>@endif
                        <div class="mt-8 flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 dark:border-[#2e4655] pt-6"><a href="{{ route($indexRoute) }}" class="rounded-xl border border-slate-300 dark:border-[#496172] px-5 py-3 text-sm font-semibold text-slate-600 dark:text-[#b3c6d3] hover:bg-slate-50 dark:[&:hover]:bg-[#263e4c]">Cancel</a><button type="submit" :disabled="saving" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-teal-800 focus-visible:ring-2 focus-visible:ring-teal-500 disabled:opacity-60"><x-care-icon name="check"/><span x-text="saving ? 'Saving...' : '{{ $mode === 'edit' ? 'Save changes' : 'Save '.strtolower($label) }}'">{{ $mode === 'edit' ? 'Save changes' : 'Save '.strtolower($label) }}</span></button></div>
                    </form>
                @endif
                @if($mode === 'show' && $record)
                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 dark:border-[#2e4655] bg-slate-50/50 dark:bg-[#142532] px-5 py-5 sm:px-7">
                        @can($deletePermissions[$module])<form method="POST" action="{{ route($module.'.destroy', $record) }}" onsubmit="return confirm('Delete this record? This action cannot be undone.')">@csrf @method('DELETE')<button type="submit" class="rounded-xl border border-red-200 dark:border-[#70454b] bg-white dark:bg-[#142532] px-5 py-3 text-sm font-semibold text-red-700 dark:text-[#ffb4b4] hover:bg-red-50 dark:[&:hover]:bg-[#51343a]">Delete record</button></form>@endcan
                        @can($updatePermissions[$module])<a href="{{ route($module.'.edit', $record) }}" class="ml-auto rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800">Edit details</a>@endcan
                    </div>
                @endif
            </section>
            <aside class="space-y-4">
                <div class="rounded-2xl border border-teal-200 dark:border-[#38645b] bg-teal-50 dark:bg-[#193d39] p-5"><x-care-icon name="shield" class="mb-3 text-teal-700 dark:text-[#8addc8]"/><h2 class="text-sm font-bold text-teal-900 dark:text-[#8addc8]">Keep your details accurate</h2><p class="mt-3 text-xs leading-6 text-teal-800 dark:text-[#8addc8]">Use a clear name and complete information so your service is easy to identify.</p></div>
                <div class="rounded-2xl border border-slate-200 dark:border-[#2e4655] bg-white dark:bg-[#142532] p-5"><h2 class="text-sm font-bold text-slate-700 dark:text-[#e0ebf2]">Need a little guidance?</h2><p class="mt-2 text-xs leading-6 text-slate-500 dark:text-[#b3c6d3]">Find answers about your connections and billing in the help center.</p><a href="{{ route('support.index') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-teal-700 dark:text-[#8addc8]">Visit help center <span aria-hidden="true">→</span></a></div>
            </aside>
        </div>
    </div>
</x-app-layout>
