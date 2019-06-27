<?php

namespace App\Http\Models;

use App\ModelFilters\LogFilter;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * @package App\Http\Models
 *
 * @property integer $id
 * @property integer $ip
 * @property Carbon $date
 * @property string|null $url
 * @property string $os
 * @property string|null $architecture
 * @property string $browser
 */
class Log extends Model
{
    use Filterable;

    protected $table = 'logs';

    public $timestamps = false;

    /**
     * Атрибуты которые можно присвоить массово
     *
     * @var array $fillable
     */
    protected $fillable = [
        'ip',
        'date',
        'url',
        'os',
        'architecture',
        'browser'
    ];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(LogFilter::class);
    }
}
