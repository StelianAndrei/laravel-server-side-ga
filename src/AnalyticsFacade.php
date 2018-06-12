<?php

namespace StelianAndrei\LaravelServerSideGA;

use Illuminate\Support\Facades\Facade;

class AnalyticsFacade extends Facade
{
    /**
     * Facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'StelianAndrei\LaravelServerSideGA\GoogleAnalytics';
    }
}
