<?php

namespace App\Http\Models;

use Carbon\Carbon;
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
    protected $table = 'logs';

    public $timestamps = false;

    /**
     * Атрибуты которые можно присвоить массово
     *
     * @var array $fillable
     */
    protected $fillable = [
        'date',
        'url',
        'os',
        'architecture',
        'browser'
    ];
}
