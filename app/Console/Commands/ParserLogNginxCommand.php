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

        while (!feof($file)) {
            $line = fgets($file);

            $log = new Log();

            preg_match('/([0-9]{1,3}[\.]){3}[0-9]{1,3}/u', $line, $matches);
            $log->ip = $matches[0];

            preg_match('/([0-9]{2}\/[a-zA-Z]{3}\/[0-9]{4}):(([0-9]{2}:){2}[0-9]{2})/u', $line, $matches);
            $log->date = Carbon::createFromTimeString(str_replace('/', '-', $matches[1] . 'T' . $matches[2]));

            preg_match('/"((http|https):\/\/[^\s]+)"/u', $line, $matches);
            $log->url = $matches[0] ?? null;

            $userAgent = $this->parser->parse($line);

            $log->os = $userAgent->os->family;
            $log->browser = $userAgent->ua->family;

            //TODO Нужно оптимизировать сохранение в один запрос
            $log->save();
        }

        fclose($file);
    }
}
