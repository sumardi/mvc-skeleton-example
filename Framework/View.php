<?php

namespace Framework;

use Framework\Exceptions\ViewNotFoundException;

class View
{
    public static function render($view, $args = [])
    {
        // convert array [name => value] to $name = value
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . '/resources/views/' . $view . '.php';

        if (is_readable($file)) {
            require $file;
        } else {
            throw new ViewNotFoundException(sprintf('View `%s` not found.', $file));
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        // Set views directory
        $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/resources/views');

        // Create twig instance
        $twig = new \Twig_Environment($loader);

        echo $twig->render($template, $args);
    }
}
