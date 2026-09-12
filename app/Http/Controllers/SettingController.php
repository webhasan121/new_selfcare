<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Setting::class);

        $settings = Setting::query()
            ->orderByRaw('category is null desc')
            ->orderBy('category')
            ->orderBy('sub_category')
            ->orderBy('name')
            ->get()
            ->groupBy(fn (Setting $setting): string => $setting->category ?: 'general');

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        Gate::authorize('update', $setting);

        $validated = $request->validate([
            'value' => ['nullable', 'string', 'max:65535'],
        ]);

        $setting->update([
            'value' => $validated['value'] ?? '',
        ]);

        return redirect()
            ->route('settings.index')
            ->with('success', "{$setting->name} updated successfully.");
    }
}
