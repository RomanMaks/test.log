<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;
use Illuminate\Routing\Controller;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Api\V1
 */
class DashboardController extends Controller
{
    public function __invoke(DashboardRequest $request)
    {
        $logs = Log::filter($request->all())
            ->popular()->limit(10)->get();
        //->paginateFilter(10);

        $os = Log::availableOs()
            ->pluck('os');

//        dd($logs);

        return response()->json([
            'logs' => $logs->toArray(),
            'os' => $os->toArray()
        ]);
    }
}
