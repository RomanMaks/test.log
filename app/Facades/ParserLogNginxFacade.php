<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ParserLogNginxFacade
 * @package App\Facades
 */
class ParserLogNginxFacade extends Facade
{
    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'parser';
    }
}
