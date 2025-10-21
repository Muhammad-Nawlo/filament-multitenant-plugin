<?php

namespace MuhammadNawlo\MultitenantPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MuhammadNawlo\MultitenantPlugin\MultitenantPlugin
 */
class MultitenantPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MuhammadNawlo\MultitenantPlugin\MultitenantPlugin::class;
    }
}
