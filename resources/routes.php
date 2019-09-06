<?php

$router->get('/', ['controller' => 'Welcome', 'action' => 'index']);
$router->get('/register', ['controller' => 'Register', 'action' => 'index']);
$router->post('/register', ['controller' => 'Register', 'action' => 'store']);
$router->get('/login', ['controller' => 'Login', 'action' => 'index']);
$router->post('/login', ['controller' => 'Login', 'action' => 'attempt']);
$router->get('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
$router->get('/logout', ['controller' => 'Login', 'action' => 'logout']);
