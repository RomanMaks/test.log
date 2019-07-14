<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;
use Illuminate\Routing\Controller;

/**
 * Контроллер отдает данные для построения графика
 * число запросов в день для трёх популярных браузеров
 *
 * Class ChartBarStackedController
 * @package App\Http\Controllers\Api\V1\Dashboard
 */
class ChartBarStackedController extends Controller
{
    public function __invoke(DashboardRequest $request)
    {
        $requestsFromBrowser = Log::filter($request->all())
            ->requestsFromBrowser();

        $threePopularBrowsers = Log::fromSub($requestsFromBrowser, 'three_popular_browsers')
            ->select([
                'date',
                'browser',
                'share_of'
            ])
            ->where('row_num', '<', 4)
            ->get();

        dd($threePopularBrowsers->toArray());

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