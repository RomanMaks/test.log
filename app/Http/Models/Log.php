<?php

namespace App\Http\Models;

use App\ModelFilters\LogFilter;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder AS QueryBuilder;
use Illuminate\Support\Facades\DB;

/**
 * Class Log
 * @package App\Http\Models
 *
 * @property integer $id
 * @property integer $ip
 * @property Carbon $requested_at
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
        'requested_at',
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

    /**
     * Доступные ОС
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailableOs(Builder $query): Builder
    {
        return $query
            ->select('os')
            ->distinct();
    }

    /**
     * Самый популярный запрос
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query
            ->fromSub(function (QueryBuilder $query) {
                return $query->from($this->table)
                    ->select([
                        DB::raw('DATE(`requested_at`) AS date'),
                        DB::raw('COUNT(*) AS count'),
                        'url',
                        'browser',
                        'os',
                        'architecture'
                    ])
                    ->groupBy(['date', 'url', 'browser', 'os', 'architecture'])
                    ->orderByDesc('count');
            }, 'popular');
    }

    /**
     * Запросов в день
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRequestsPerDay(Builder $query): Builder
    {
        return $query
            ->fromSub(function (QueryBuilder $query) {
                return $query->from($this->table)
                    ->select([
                        DB::raw('DATE(`requested_at`) AS date'),
                        DB::raw('COUNT(*) AS count'),
                        'os',
                        'architecture'
                    ])
                    ->groupBy(['date', 'os', 'architecture'])
                    ->orderByDesc('count');
            }, 'popular')
            ->select(['date', 'count']);
    }

    /**
     * Запросов в день для каждого браузера
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRequestsFromBrowser(Builder $query): Builder
    {
        return $query
            ->fromSub(function (QueryBuilder $query) {
                return $query->from($this->table)
                    ->select([
                        DB::raw('DATE(`requested_at`) AS date'),
                        'browser',
                        'os',
                        'architecture',
                        DB::raw('COUNT(*) AS count')
                    ])
                    ->groupBy(['date', 'browser', 'os', 'architecture'])
                    ->orderByDesc('count');
            }, 'popular')
            ->select([
                'date',
                'browser',
                'os',
                'architecture',
                DB::raw('((count * 100) / SUM(count) OVER (PARTITION BY date)) AS share_of'),
                DB::raw('(row_number() OVER (PARTITION BY date)) AS row_num')
            ]);
    }
}
