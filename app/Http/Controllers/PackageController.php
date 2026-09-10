<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelfCareIndexRequest;
use App\Models\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(SelfCareIndexRequest $request): View|JsonResponse
    {
        $connections = Connection::forUser($request->user())->orderBy('name')->get();
        $selected = null;

        if ($id = $request->validated('connection')) {
            $selected = $connections->firstWhere('id', $id);
            abort_unless($selected, 404);
        }

        // Preview data only. Replace this collection with the provider API response later.
        $packages = collect([
            ['id' => 'demo-basic', 'name' => 'Home Basic', 'speed_mbps' => 20, 'price' => 500, 'active' => false, 'expire_date' => null, 'action' => 'Downgrade', 'description' => 'Everyday browsing, social media and staying connected.'],
            ['id' => 'demo-plus', 'name' => 'Home Plus', 'speed_mbps' => 50, 'price' => 1000, 'active' => true, 'expire_date' => today()->addDays(20)->format('d M Y'), 'action' => null, 'description' => 'Smooth streaming, video calls and work from home.'],
            ['id' => 'demo-pro', 'name' => 'Home Pro', 'speed_mbps' => 100, 'price' => 1500, 'active' => false, 'expire_date' => null, 'action' => 'Upgrade', 'description' => 'More speed for gaming, downloads and the whole family.'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $packages,
                'meta' => ['available' => true, 'demo' => true],
            ]);
        }

        return view('packages.index', compact('connections', 'selected', 'packages') + [
            'section' => 'packages',
        ]);
    }
}

