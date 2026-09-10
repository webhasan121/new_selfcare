<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Database\QueryException;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

use App\Models\WorkspacePreference;

use App\Http\Requests\SaveWorkspacePreferenceRequest;

use App\Http\Requests\SelfCareIndexRequest;
use App\Http\Resources\DashboardResource;
use App\Models\Connection;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(SelfCareIndexRequest $request): View|JsonResource|RedirectResponse
    {
        if ($section = $request->validated('section')) {
            $selected = null;
            if ($id = $request->validated('connection')) {
                $selected = Connection::forUser($request->user())->findOrFail($id);

            }

            return redirect()->route(
                $section === 'overview' ? 'dashboard' : $section . '.index',
                array_filter(['connection' => $request->validated('connection')])
            );
        }


        $selected = null;
        if ($id = $request->validated('connection')) {
            $selected = Connection::forUser($request->user())->findOrFail($id);

        }
        $preference = WorkspacePreference::where('user_id', $request->user()->id)->first();
        if (! $request->query->has('connection') && $preference && $preference->default_view !== 'all') {
            $selected = Connection::forUser($request->user())->where('type', $preference->default_view)->orderBy('name')->first();
        }
        $context = [
            'preference' => $preference,
            'connections' => Connection::forUser($request->user())->orderBy('name')->get(),
            'selected' => $selected,
        ];
        $invoices = Invoice::forUser($request->user())
            ->when($selected, fn($query) => $query->where('connection_id', $selected->id));
        $data = $context + [
            'section' => 'overview',
            'visibleConnections' => Connection::forUser($request->user())
                ->when($selected, fn($query) => $query->whereKey($selected->id))
                ->with([
                    'subscriptions' => fn($query) => $query
                        ->where('status', 'active')->whereDate('start_date', '<=', today())
                        ->whereDate('end_date', '>=', today())->latest('start_date')->with('package')
                ])
                ->orderBy('name')->get(),
            'invoices' => (clone $invoices)->with('connection')->latest('due_date')->limit(5)->get(),
            'unpaidCount' => $invoices->whereIn('status', ['unpaid', 'partially_paid'])->count(),
        ];

        return $request->expectsJson() ? new DashboardResource($data) : view('dashboard', $data);
    }


    public function create(): View|RedirectResponse
    {

        $existing = WorkspacePreference::where('user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->route('dashboard.edit', $existing);
        }

        $record = null;

        return view('dashboard.create', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function store(SaveWorkspacePreferenceRequest $request): RedirectResponse
    {

        try {
            $record = DB::transaction(function () use ($request) {
                User::whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
                if (WorkspacePreference::where('user_id', $request->user()->id)->exists()) {
                    throw ValidationException::withMessages(['name' => 'You already have workspace preferences. Edit the existing record.']);
                }
                $record = new WorkspacePreference($request->validated());
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

        return redirect()->route('dashboard.show', $record)->with('success', 'Workspace preference created successfully.');
    }

    public function show(string $id): View
    {
        $record = WorkspacePreference::where('user_id', auth()->id())->findOrFail($id);


        return view('dashboard.show', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function edit(string $id): View
    {
        $record = WorkspacePreference::where('user_id', auth()->id())->findOrFail($id);


        return view('dashboard.edit', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function update(SaveWorkspacePreferenceRequest $request, string $id): RedirectResponse
    {
        try {
            $record = DB::transaction(function () use ($request, $id) {
                $record = WorkspacePreference::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

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

        return redirect()->route('dashboard.show', $record)->with('success', 'Workspace preference updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $record = WorkspacePreference::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                $record->delete();
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record has related history and cannot be deleted. Keep it or make it inactive instead.']);
            }
            throw $exception;
        }

        return redirect()->route('dashboard')->with('success', 'Workspace preference deleted successfully.');
    }
}

