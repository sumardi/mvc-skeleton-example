<?php

namespace App\Controllers;

class UserController extends Controller
{
    public function __construct()
    {
        session_start();

        // Force login
        if (!isset($_SESSION['user'])) {
            redirect('/login');
        }
    }

    public function user()
    {
        return $_SESSION['user'];
    }
}
