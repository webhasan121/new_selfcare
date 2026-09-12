<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUsageReportRequest;
use App\Http\Requests\SelfCareIndexRequest;
use App\Models\Connection;
use App\Models\UsageReport;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UsageController extends Controller
{
    public function index(SelfCareIndexRequest $request): View
    {
        Gate::authorize('viewAny', UsageReport::class);
        $selected = null;
        if ($id = $request->validated('connection')) {
            $selected = Connection::forUser($request->user())->findOrFail($id);

        }
        $context = [
            'connections' => Connection::forUser($request->user())->orderBy('name')->get(),
            'selected' => $selected,
        ];

        $records = UsageReport::where('user_id', $request->user()->id)
            ->when($selected, fn ($query) => $query->where('connection_id', $selected->id))
            ->with('connection')->latest()->paginate(10)->withQueryString();

        return view('usage.index', $context + ['section' => 'usage', 'records' => $records]);
    }

    public function create(): View|RedirectResponse
    {
        Gate::authorize('create', UsageReport::class);

        $record = null;

        return view('usage.create', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function store(SaveUsageReportRequest $request): RedirectResponse
    {
        Gate::authorize('create', UsageReport::class);

        try {
            $record = DB::transaction(function () use ($request) {
                $record = new UsageReport($request->validated());
                $record->user()->associate($request->user());
                $record->save();

                return $record;
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record conflicts with existing data. Please review the fields and try again.']);
            }
            throw $exception;
        }

        return redirect()->route('usage.show', $record)->with('success', 'Usage report criteria created successfully.');
    }

    public function show(string $id): View
    {
        $record = UsageReport::where('user_id', auth()->id())->findOrFail($id);
        Gate::authorize('view', $record);

        return view('usage.show', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function edit(string $id): View
    {
        $record = UsageReport::where('user_id', auth()->id())->findOrFail($id);
        Gate::authorize('update', $record);

        return view('usage.edit', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function update(SaveUsageReportRequest $request, string $id): RedirectResponse
    {
        $record = UsageReport::where('user_id', $request->user()->id)->findOrFail($id);
        Gate::authorize('update', $record);

        try {
            $record = DB::transaction(function () use ($request, $id) {
                $record = UsageReport::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                $record->fill($request->validated());
                $record->save();

                return $record;
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This update conflicts with existing data. Please review the fields.']);
            }
            throw $exception;
        }

        return redirect()->route('usage.show', $record)->with('success', 'Usage report criteria updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $record = UsageReport::where('user_id', auth()->id())->findOrFail($id);
        Gate::authorize('delete', $record);

        try {
            DB::transaction(function () use ($id) {
                $record = UsageReport::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                $record->delete();
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record has related history and cannot be deleted. Keep it or make it inactive instead.']);
            }
            throw $exception;
        }

        return redirect()->route('usage.index')->with('success', 'Usage report criteria deleted successfully.');
    }
}
