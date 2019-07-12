<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

/**
 * Фильтр для таблицы и графика
 *
 * Class LogFilter
 * @package App\ModelFilters
 */
class LogFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * Фильтр по дате
     *
     * @param $date
     * @return LogFilter
     */
    public function date($date): LogFilter
    {
        return $this->where('date', '=', $date);
    }

    /**
     * Фильтр по операционной системе
     *
     * @param $os
     * @return LogFilter
     */
    public function os($os): LogFilter
    {
        return $this->where('os', '=', $os);
    }

    /**
     * Фильтр по архитектуре
     *
     * @param $architecture
     * @return LogFilter
     */
    public function architecture($architecture): LogFilter
    {
        return $this->where('architecture', '=', $architecture);
    }
}
