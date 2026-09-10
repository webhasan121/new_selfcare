@if(session('success'))
    <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 dark:border-[#38645b] bg-emerald-50 dark:bg-[#193d39] p-4 text-sm font-medium text-emerald-800 dark:text-[#8addc8]"><x-care-icon name="check"/><span>{{ session('success') }}</span></div>
@endif
@if($errors->any())
    <div role="alert" class="mb-6 rounded-xl border border-red-200 dark:border-[#70454b] bg-red-50 dark:bg-[#3f282e] p-4 text-sm text-red-800 dark:text-[#ffb4b4]"><p class="font-bold">Please check the following:</p><ul class="mt-2 list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

