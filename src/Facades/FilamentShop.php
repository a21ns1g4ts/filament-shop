<?php

namespace A21ns1g4ts\FilamentShop\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \A21ns1g4ts\FilamentShop\FilamentShop
 */
class FilamentShop extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \A21ns1g4ts\FilamentShop\FilamentShop::class;
    }
}
