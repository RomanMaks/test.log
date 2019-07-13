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
        $requestsPerDay = Log::filter($request->all())
            ->requestsPerDay()
            ->get();

        $chart = [];

        foreach ($requestsPerDay as $item) {
            if (!isset($chart[$item['date']])) {
                $chart[$item['date']] = $item['count'];
            } else {
                $chart[$item['date']] += $item['count'];
            }
        }

        return response()->json([
            'labels' => array_keys($chart),
            'datasets' => [
                [
                    'label' => 'Число запросов',
                    'background' => '#F26202',
                    'data' => array_values($chart)
                ]
            ]
        ]);
    }
}