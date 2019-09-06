<?php

namespace App\Controllers;

use App\Models\UserModel as User;

class RegisterController extends Controller
{
    public function index()
    {
        // Show registration form
        $this->view('register');
    }

    public function store()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : '';

        // Save new user into database.
        $user = new User();
        $user->create(compact('name', 'email', 'password'));

        // Redirect back to home page.
        redirect('/');
    }
}
