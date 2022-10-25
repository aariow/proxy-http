<?php

use App\Application;

if (!function_exists('app')) {
    function app($abstract = null)
    {
        if ($abstract)
            return Application::getInstance()->resolve($abstract);

        return Application::getInstance();
    }
}

if (!function_exists('config')) {
    function config($key)
    {
        return app('config')->get($key);
    }
}