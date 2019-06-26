<?php

namespace App\Http\Controllers;

use App\Http\Models\Log;

/**
 * Контроллер по работа с приборной доской
 *
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    public function index()
    {
        $logs = Log::paginate(10);
        return view('dashboard', compact('logs'));
    }
}
