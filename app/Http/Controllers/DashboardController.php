<?php

namespace App\Http\Controllers;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Контроллер по работа с приборной доской
 *
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    public function index(DashboardRequest $request)
    {
        $logs = Log::filter($request->all())
            ->popular()->limit(10)->get();
            //->paginateFilter(10);

        $os = Log::availableOs()
            ->pluck('os');

//        dd($logs);

        if ($request->expectsJson()) {
            return response()->json([
                'logs' => $logs->toArray(),
                'os' => $os->toArray()
            ]);
//            return new JsonResource([
//                'logs' => $logs->toArray()['data'],
//                'os' => $os->toArray()
//            ]);
        }

        return view('dashboard', compact('logs', 'os'));

//        if ($request->expectsJson()) {
//            $users = User::with('info')->filter($filters)->get();
//            return response()->json($users->toArray());
//        }
    }
}
