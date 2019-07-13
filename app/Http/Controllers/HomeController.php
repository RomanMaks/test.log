<?php

namespace App\Http\Controllers;

/**
 * Контроллер отобразит шаблон приборной доски
 *
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
