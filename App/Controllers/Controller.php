<?php

namespace App\Controllers;

use Framework\View;

class Controller
{
    public function view($view, $args = [])
    {
        View::render($view, $args);
    }

    public function template($template, $args = [])
    {
        View::renderTemplate($template, $args);
    }
}
