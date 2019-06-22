<?php

namespace App\Console\Commands;

use App\Facades\ParserLogNginxFacade;
use Illuminate\Console\Command;

class ParserLogNginx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:log:nginx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command is intended for the analysis of "nginx" logs.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = ParserLogNginxFacade::run();
        $this->info($result);
    }
}
