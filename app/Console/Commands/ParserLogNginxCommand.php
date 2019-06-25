<?php

namespace App\Console\Commands;

use App\Http\Models\Log;
use Carbon\Carbon;
use Illuminate\Console\Command;
use UAParser\Parser;

/**
 * Class ParserLogNginxCommand
 * @package App\Console\Commands
 */
class ParserLogNginxCommand extends Command
{
    const FILE = __DIR__ . '/../../../modimio.access.log';

    const INSERT_LIMIT = 1000;

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
        $logs = [];

        while (!feof($file)) {
            $line = fgets($file);

            if (self::INSERT_LIMIT === $insertLimit) {
                Log::insert($logs);
                $insertLimit = 0;
                $logs = [];
            }

            preg_match('/([0-9]{1,3}[\.]){3}[0-9]{1,3}/u', $line, $matches);
            if (empty($matches[0])) {
                continue;
            }

            $logs[$insertLimit]['ip'] = ip2long($matches[0]);

            preg_match('/([0-9]{2}\/[a-zA-Z]{3}\/[0-9]{4}):(([0-9]{2}:){2}[0-9]{2})/u', $line, $matches);
            $logs[$insertLimit]['date'] = Carbon::createFromTimeString(str_replace('/', '-', $matches[1] . 'T' . $matches[2]));

            preg_match('/"((http|https):\/\/[^\s]+)"/u', $line, $matches);
            $logs[$insertLimit]['url'] = $matches[0] ?? null;

            $userAgent = $this->parser->parse($line);

            if (preg_match('/(Win64; x64;|WOW64;|x86_64;)/u', $line)) {
                $logs[$insertLimit]['architecture'] = 'x64';
            } elseif (preg_match('/i686;/u', $line)) {
                $logs[$insertLimit]['architecture'] = 'x86';
            } else {
                $logs[$insertLimit]['architecture'] = null;
            }

            $logs[$insertLimit]['os'] = $userAgent->os->family;
            $logs[$insertLimit]['browser'] = $userAgent->ua->family;

            $insertLimit++;
        }

        if (!empty($insertLimit)) {
            Log::insert($logs);
        }

        fclose($file);
    }
}
