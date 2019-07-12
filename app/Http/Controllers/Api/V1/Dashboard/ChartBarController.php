<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;
use Illuminate\Routing\Controller;

/**
 * Контроллер отдает данные для построения графика
 * число запросов в день
 *
 * Class ChartBarController
 * @package App\Http\Controllers\Api\V1\Dashboard
 */
class ChartBarController extends Controller
{
    public function __invoke(DashboardRequest $request)
    {
        $logs = Log::filter($request->all())
            ->popular()->get();

//        dd($logs);

        return response()->json([
            'chart' => $logs->toArray()
        ]);
    }
}