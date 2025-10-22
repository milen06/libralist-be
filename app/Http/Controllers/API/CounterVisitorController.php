<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CounterVisitorController extends Controller
{
    public function count(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $ipKey = 'visited_' . $today . '_' . $request->ip();

        if (!cache()->has($ipKey)) {
            $setting = WebSetting::first();

            if ($setting) {
                $setting->increment('total_visitors');
            }

            cache()->put($ipKey, true, now()->addDay());
        }

        return response()->json(['status' => 'ok']);
    }

    public function total()
    {
        $setting = WebSetting::first();

        return response()->json([
            'total_visitors' => (int) $setting?->total_visitors ?? 0,
        ]);
    }
}