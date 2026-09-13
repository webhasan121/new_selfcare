<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelfCareIndexRequest;
use App\Models\Connection;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(SelfCareIndexRequest $request): View|RedirectResponse
    {
        Gate::authorize('dashboard.view');

        if ($section = $request->validated('section')) {
            $selected = null;
            if ($id = $request->validated('connection')) {
                $selected = Connection::forUser($request->user())->findOrFail($id);

            }

            return redirect()->route(
                $section === 'overview' ? 'dashboard' : $section.'.index',
                array_filter(['connection' => $request->validated('connection')])
            );
        }

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
            'section' => 'overview',
            'visibleConnections' => Connection::forUser($request->user())
                ->when($selected, fn ($query) => $query->whereKey($selected->id))
                ->with([
                    'subscriptions' => fn ($query) => $query
                        ->where('status', 'active')->whereDate('start_date', '<=', today())
                        ->whereDate('end_date', '>=', today())->latest('start_date')->with('package'),
                ])
                ->orderBy('name')->get(),
            'invoices' => (clone $invoices)->with('connection')->latest('due_date')->limit(5)->get(),
            'unpaidCount' => $invoices->whereIn('status', ['unpaid', 'partially_paid'])->count(),
        ];

        return view('dashboard', $data);
    }

}
