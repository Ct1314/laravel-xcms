<?php
namespace Flash;

use Illuminate\Support\Facades\Facade;

class FlashFacade extends Facade
{
    /**
     * @name getFacadeAccessor
     * @desc use static Flash method facade
     * @author Yuanchang.xu
     * @since 2016.08.08
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Flash\Flash::class;
    }
}