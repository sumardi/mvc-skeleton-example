<?php

namespace App\Controllers;

use App\Models\UserModel as User;

class LoginController extends Controller
{
    public function index()
    {
        $this->view('login');
    }

    public function attempt()
    {
        $validation = $this->validate($_POST['email'], $_POST['password']);

        if (is_array($validation)) {
            // If login successful, redirect to /dashboard
            session_start();
            $_SESSION['user'] = $validation;
            redirect('/dashboard');
        }

        // If failed, go back to /login
        redirect('/login');
    }

    protected function validate($email, $password)
    {
        $user = new User();
        $auth = $user->where(compact('email'));

        if ($auth) {
            foreach ($auth as $u) {
                $verify = password_verify($password, $u['password']);
                if ($verify) {
                    return $u;
                }
            }
        }

        return false;
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);

        redirect('/login');
    }
}
