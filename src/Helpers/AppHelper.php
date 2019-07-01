<?php
namespace App\Helpers;

use App\System\App;

class AppHelper
{
    public static function app()
    {
        return App::getInstance(BASEPATH);
    }

    public static function config($key)
    {
        $config = static::app()->get('config');
        return $config->get($key);
    }
}