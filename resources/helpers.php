<?php

if (!function_exists('debug')) {
    function debug($value)
    {
        echo "<pre>";
        var_dump($value);
        exit();
        echo "</pre>";
    }
}

if (!function_exists('url')) {
    function url($uri)
    {
        return App\Config::URL . $uri;
    }
}

if (!function_exists('css')) {
    function css($name)
    {
        return App\Config::URL . '/css/' . $name;
    }
}

if (!function_exists('js')) {
    function js($name)
    {
        return App\Config::URL . '/js/' . $name;
    }
}

if (!function_exists('redirect')) {
    function redirect($uri)
    {
        header('location:' . $uri);
        exit();
    }
}
