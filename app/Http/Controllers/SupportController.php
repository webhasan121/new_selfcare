<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

use Illuminate\Database\QueryException;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;

use App\Models\SupportTicket;

use App\Http\Requests\SaveSupportTicketRequest;

use App\Http\Requests\SelfCareIndexRequest;
use App\Models\Connection;
use Illuminate\View\View;

class SupportController extends Controller
{
    public function index(SelfCareIndexRequest $request): View
    {
        $selected = null;
        if ($id = $request->validated('connection')) {
            $selected = Connection::forUser($request->user())->findOrFail($id);

        }
        $context = [
            'connections' => Connection::forUser($request->user())->orderBy('name')->get(),
            'selected' => $selected,
        ];

        $records = SupportTicket::where('user_id', $request->user()->id)
            ->when($selected, fn ($query) => $query->where('connection_id', $selected->id))
            ->with('connection')->latest()->paginate(10)->withQueryString();

        return view('support.index', $context + ['section' => 'support', 'records' => $records]);
    }


    public function create(): View|RedirectResponse
    {


        $record = null;

        return view('support.create', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function store(SaveSupportTicketRequest $request): RedirectResponse
    {

        try {
            $record = DB::transaction(function () use ($request) {
                $record = new SupportTicket($request->validated());
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

        return redirect()->route('support.show', $record)->with('success', 'Support ticket created successfully.');
    }

    public function show(string $id): View
    {
        $record = SupportTicket::where('user_id', auth()->id())->findOrFail($id);


        return view('support.show', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function edit(string $id): View
    {
        $record = SupportTicket::where('user_id', auth()->id())->findOrFail($id);


        return view('support.edit', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function update(SaveSupportTicketRequest $request, string $id): RedirectResponse
    {
        try {
            $record = DB::transaction(function () use ($request, $id) {
                $record = SupportTicket::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                if ($record->status !== 'open') {
                    throw ValidationException::withMessages(['record' => 'Only open tickets can be edited.']);
                }
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

        return redirect()->route('support.show', $record)->with('success', 'Support ticket updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $record = SupportTicket::where('user_id', auth()->id())->lockForUpdate()->findOrFail($id);

                $record->delete();
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record has related history and cannot be deleted. Keep it or make it inactive instead.']);
            }
            throw $exception;
        }

        return redirect()->route('support.index')->with('success', 'Support ticket deleted successfully.');
    }
}

