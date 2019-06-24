<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('welcome');
    }
}
