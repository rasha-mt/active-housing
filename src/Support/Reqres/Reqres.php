<?php

namespace Support\Reqres;

use Illuminate\Support\Facades\Facade;

/**
 * class ReqresFacade
 *
 *
 * @method static string getUserById($userId)
 * @method static string getUsersList($page)
 */
class Reqres extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReqresManager::class;
    }

}