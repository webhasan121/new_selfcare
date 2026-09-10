<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

use Illuminate\Database\QueryException;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

use App\Http\Requests\SaveConnectionRequest;

use App\Http\Requests\SelfCareIndexRequest;
use App\Http\Resources\ConnectionResource;
use App\Models\Connection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;

class ConnectionController extends Controller
{
    public function index(SelfCareIndexRequest $request): View|JsonResource
    {

        $selected = null;
        if ($id = $request->validated('connection')) {
            $selected = Connection::forUser($request->user())->findOrFail($id);

        }
        $context = [
            'connections' => Connection::forUser($request->user())->orderBy('name')->get(),
            'selected' => $selected,
        ];
        $rows = Connection::forUser($request->user())
            ->when($selected, fn($query) => $query->whereKey($selected->id))
            ->with([
                'subscriptions' => fn($query) => $query
                    ->where('status', 'active')->whereDate('start_date', '<=', today())
                    ->whereDate('end_date', '>=', today())->latest('start_date')->with('package')
            ])
            ->orderBy('name')->get();

        return $request->expectsJson()
            ? ConnectionResource::collection($rows)
            : view('connections.index', $context + ['section' => 'connections', 'visibleConnections' => $rows]);
    }


    public function create(): View|RedirectResponse
    {


        $record = null;

        return view('connections.create', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function store(SaveConnectionRequest $request): RedirectResponse
    {
        if (! $this->providerUserExists($request->validated('username'), $request->validated('password'))) {
            throw ValidationException::withMessages([
                'username' => 'The provider could not verify this username and password.',
            ]);
        }
        try {
            $record = DB::transaction(function () use ($request) {
                $record = new Connection($request->validated());
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

        return redirect()->route('connections.show', $record)->with('success', 'Connection created successfully.');
    }

    protected function providerUserExists(string $username, string $password): bool
    {
        // Sample availability check only: JSONPlaceholder does not verify credentials.
        // Do not send customer credentials to this public demo endpoint.
        // Replace the URL and response check with real provider verification later.
        try {
            $response = Http::acceptJson()->connectTimeout(5)->timeout(10)
                ->get('https://jsonplaceholder.typicode.com/todos/1');

            return $response->successful() && $response->json('id') === 1;
        } catch (ConnectionException $exception) {
            return false;
        }
    }

    public function show(string $id): View
    {
        $record = Connection::where('user_id', auth()->id())->findOrFail($id);


        return view('connections.show', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function edit(string $id): View
    {
        $record = Connection::where('user_id', auth()->id())->findOrFail($id);


        return view('connections.edit', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function update(SaveConnectionRequest $request, string $id): RedirectResponse
    {
        try {
            $record = DB::transaction(function () use ($request, $id) {
                $record = Connection::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

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

        return redirect()->route('connections.show', $record)->with('success', 'Connection updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $record = Connection::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                if (! in_array($record->status, ['pending', 'inactive'], true)) {
                    throw ValidationException::withMessages(['record' => 'Only pending or inactive connections can be deleted. Contact your provider to stop an active service.']);
                }
                $record->delete();
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record has related history and cannot be deleted. Keep it or make it inactive instead.']);
            }
            throw $exception;
        }

        return redirect()->route('connections.index')->with('success', 'Connection deleted successfully.');
    }
}
