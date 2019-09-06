<?php

namespace App\Controllers;

class DashboardController extends UserController
{
    public function index()
    {
        // Retrieve authenticated user
        $user = $this->user();

        $this->view('dashboard', compact('user'));
    }
}
