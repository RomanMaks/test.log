<?php

namespace App\Console\Commands;

use App\Http\Models\Log;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use UAParser\Parser;

/**
 * Class ParserLogNginxCommand
 * @package App\Console\Commands
 */
class ParserLogNginxCommand extends Command
{
    const FILE = __DIR__ . '/../../../modimio.access.log';

    const INSERT_LIMIT = 100000;

    protected $parser;

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
     * ParserLogNginxCommand constructor.
     * @throws \UAParser\Exception\FileNotFoundException
     */
    public function __construct()
    {
        $this->parser = Parser::create();

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \UAParser\Exception\FileNotFoundException
     */
    public function handle()
    {
        // Открываем файл на чтение
        $file = @fopen(self::FILE, 'r');

        if (!$file) {
            return;
        }

        $insertLimit = 0;
        $log = [];

        while (!feof($file)) {
            $line = fgets($file);

            if (self::INSERT_LIMIT === $insertLimit) {
                Log::insert($log);
                $insertLimit = 0;
                $log = [];
            }

            preg_match('/([0-9]{1,3}[\.]){3}[0-9]{1,3}/u', $line, $matches);
            if (empty($matches[0])) {
                continue;
            }

            $log[$insertLimit]['ip'] = ip2long($matches[0]);

            preg_match('/([0-9]{2}\/[a-zA-Z]{3}\/[0-9]{4}):(([0-9]{2}:){2}[0-9]{2})/u', $line, $matches);
            $log[$insertLimit]['date'] = Carbon::createFromTimeString(str_replace('/', '-', $matches[1] . 'T' . $matches[2]));

            preg_match('/"((http|https):\/\/[^\s]+)"/u', $line, $matches);
            $log[$insertLimit]['url'] = $matches[0] ?? null;

            $userAgent = $this->parser->parse($line);

            $log[$insertLimit]['os'] = $userAgent->os->family;
            $log[$insertLimit]['browser'] = $userAgent->ua->family;

            $insertLimit++;
        }

        fclose($file);
    }
}
