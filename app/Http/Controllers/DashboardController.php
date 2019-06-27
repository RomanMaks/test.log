<?php

namespace App\Http\Controllers;

use App\Http\Models\Log;
use App\Http\Requests\DashboardRequest;

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
            ->paginateFilter(10);

        return view('dashboard', compact('logs'));
    }
}
