<x-app-layout>
    <div class="mb-7">
        <div class="text-[9px] font-bold tracking-[1.7px] text-[#6d8991] dark:text-[#8faab9]">ADMINISTRATION</div>
        <h1 class="mt-2 text-[29px] font-bold tracking-[-1px] text-[#1b3440] dark:text-[#e2edf2]">Settings</h1>
        <p class="mt-1 text-[13px] text-[#82909a] dark:text-[#a3b6c2]">Manage application settings loaded from the database.</p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse ($settings as $category => $categorySettings)
            <section class="overflow-hidden rounded-2xl border border-[#e2e8e9] bg-white shadow-sm dark:border-[#304653] dark:bg-[#142a35]">
                <div class="border-b border-[#edf1f2] px-6 py-4 dark:border-[#304653]">
                    <h2 class="text-base font-bold capitalize text-[#1b3440] dark:text-[#e2edf2]">{{ str_replace('_', ' ', $category) }}</h2>
                </div>
                <div class="divide-y divide-[#edf1f2] dark:divide-[#304653]">
                    @foreach ($categorySettings as $setting)
                        <form method="POST" action="{{ route('settings.update', $setting) }}" class="grid gap-4 px-6 py-5 lg:grid-cols-[minmax(220px,0.8fr)_minmax(280px,1.5fr)_auto] lg:items-end">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="setting-{{ $setting->id }}" class="block text-sm font-semibold text-[#29444f] dark:text-[#d9e8ed]">{{ str_replace('_', ' ', ucfirst($setting->name)) }}</label>
                                <div class="mt-1 text-[11px] text-[#8a9aa1]">
                                    {{ collect([$setting->sub_category, $setting->type])->filter()->join(' · ') }}
                                </div>
                                @if ($setting->description)
                                    <p class="mt-2 whitespace-pre-line text-xs leading-5 text-[#71838b] dark:text-[#9db0ba]">{{ $setting->description }}</p>
                                @endif
                            </div>
                            <div>
                                @if (str_contains(strtolower($setting->name), 'password'))
                                    <input id="setting-{{ $setting->id }}" name="value" type="password" value="{{ $setting->value }}" autocomplete="new-password"
                                        class="w-full rounded-xl border-[#d8e2e4] text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-[#405762] dark:bg-[#10242e] dark:text-white">
                                @elseif (in_array($setting->type, ['json', 'html', 'serialize', 'delimited'], true) || strlen($setting->value) > 100)
                                    <textarea id="setting-{{ $setting->id }}" name="value" rows="3"
                                        class="w-full rounded-xl border-[#d8e2e4] text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-[#405762] dark:bg-[#10242e] dark:text-white">{{ $setting->value }}</textarea>
                                @elseif ($setting->type === 'bool')
                                    <select id="setting-{{ $setting->id }}" name="value" class="w-full rounded-xl border-[#d8e2e4] text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-[#405762] dark:bg-[#10242e] dark:text-white">
                                        <option value="1" @selected($setting->value === '1')>Enabled</option>
                                        <option value="0" @selected($setting->value === '0')>Disabled</option>
                                    </select>
                                @else
                                    <input id="setting-{{ $setting->id }}" name="value" type="text" value="{{ $setting->value }}"
                                        class="w-full rounded-xl border-[#d8e2e4] text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-[#405762] dark:bg-[#10242e] dark:text-white">
                                @endif
                                @error('value')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="rounded-xl bg-[#168f80] px-4 py-2.5 text-xs font-bold text-white hover:bg-[#11796d]">Save</button>
                        </form>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="rounded-2xl border border-dashed border-[#d8e2e4] p-10 text-center text-sm text-[#71838b] dark:border-[#405762]">No settings were found in the database.</div>
        @endforelse
    </div>
</x-app-layout>
