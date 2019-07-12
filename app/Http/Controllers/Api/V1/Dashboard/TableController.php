<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;
use Illuminate\Routing\Controller;

/**
 * Контроллер отдает данные для заполнения таблицы
 *
 * Class TableController
 * @package App\Http\Controllers\Api\V1\Dashboard
 */
class TableController extends Controller
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
