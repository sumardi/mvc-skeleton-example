<?php

/**
 * Autoload composer
 */
require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('Framework\ErrorHandler::errorHandler');
set_exception_handler('Framework\ErrorHandler::exceptionHandler');

$router = new \Framework\Router;
$app = new \Framework\Application($router);
$app->run();
