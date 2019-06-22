<?php

namespace App\Providers;

use App\Console\Commands\ParserLogNginx;
use Illuminate\Support\ServiceProvider;

class PaarserLogNginxProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('parser', ParserLogNginx::class);
    }
}
