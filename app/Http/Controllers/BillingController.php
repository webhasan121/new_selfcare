<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveInvoiceRequest;
use App\Http\Requests\SelfCareIndexRequest;
use App\Models\Connection;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(SelfCareIndexRequest $request): View
    {
        Gate::authorize('viewAny', Invoice::class);

        $selected = null;
        if ($id = $request->validated('connection')) {
            $selected = Connection::forUser($request->user())->findOrFail($id);

        }
        $context = [
            'connections' => Connection::forUser($request->user())->orderBy('name')->get(),
            'selected' => $selected,
        ];
        $invoices = Invoice::forUser($request->user())
            ->when($selected, fn ($query) => $query->where('connection_id', $selected->id));
        $data = $context + [
            'section' => 'billing',
            'unpaidCount' => (clone $invoices)->whereIn('status', ['unpaid', 'partially_paid'])->count(),
            'invoices' => $invoices->with('connection')->latest('due_date')->paginate(10, ['*'], 'invoices_page')->withQueryString(),
            'payments' => Payment::forUser($request->user())
                ->when($selected, fn ($query) => $query->whereHas(
                    'invoices',
                    fn ($invoice) => $invoice->where('connection_id', $selected->id)
                ))
                ->with('items.invoice.connection')->latest()->paginate(5, ['*'], 'payments_page')->withQueryString(),
        ];

        return view('billing.index', $data);
    }

    public function create(): View|RedirectResponse
    {
        Gate::authorize('create', Invoice::class);

        $record = null;

        return view('billing.create', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function store(SaveInvoiceRequest $request): RedirectResponse
    {
        Gate::authorize('create', Invoice::class);

        try {
            $record = DB::transaction(function () use ($request) {
                $record = new Invoice($request->validated());
                $record->connection_id = $request->validated('connection_id');
                $record->status = 'unpaid';
                $record->save();

                return $record;
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record conflicts with existing data. Please review the fields and try again.']);
            }
            throw $exception;
        }

        return redirect()->route('billing.show', $record)->with('success', 'Invoice created successfully.');
    }

    public function show(string $id): View
    {
        $record = Invoice::forUser(auth()->user())->findOrFail($id);
        Gate::authorize('view', $record);

        return view('billing.show', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function edit(string $id): View
    {
        $record = Invoice::forUser(auth()->user())->findOrFail($id);
        Gate::authorize('update', $record);

        return view('billing.edit', [
            'record' => $record,
            'available' => true,
            'connections' => Connection::forUser(auth()->user())->orderBy('name')->get(),
        ]);
    }

    public function update(SaveInvoiceRequest $request, string $id): RedirectResponse
    {
        $record = Invoice::forUser($request->user())->findOrFail($id);
        Gate::authorize('update', $record);

        try {
            $record = DB::transaction(function () use ($request, $id) {
                $record = Invoice::forUser(auth()->user())->lockForUpdate()->findOrFail($id);

                if ($record->status !== 'unpaid' || $record->paymentItems()->exists()) {
                    throw ValidationException::withMessages(['record' => 'Invoices with payments or a final status cannot be changed.']);
                }
                if ((int) $request->validated('connection_id') !== (int) $record->connection_id) {
                    throw ValidationException::withMessages(['connection_id' => 'An existing invoice cannot be moved to another connection.']);
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

        return redirect()->route('billing.show', $record)->with('success', 'Invoice updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $record = Invoice::forUser(auth()->user())->findOrFail($id);
        Gate::authorize('delete', $record);

        try {
            DB::transaction(function () use ($id) {
                $record = Invoice::forUser(auth()->user())->lockForUpdate()->findOrFail($id);

                if ($record->status !== 'unpaid' || $record->paymentItems()->exists()) {
                    throw ValidationException::withMessages(['record' => 'Invoices with payments or a final status cannot be deleted.']);
                }
                $record->delete();
            });
        } catch (QueryException $exception) {
            if (str_starts_with((string) $exception->getCode(), '23')) {
                throw ValidationException::withMessages(['record' => 'This record has related history and cannot be deleted. Keep it or make it inactive instead.']);
            }
            throw $exception;
        }

        return redirect()->route('billing.index')->with('success', 'Invoice deleted successfully.');
    }
}
