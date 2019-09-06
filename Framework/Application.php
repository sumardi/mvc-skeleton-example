<?php

namespace Framework;

class Application
{
    /**
     * The Core Framework version
     * 
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * Router instance
     * 
     * @var \Framework\Router
     */
    protected $router;

    /**
     * Constructor
     * 
     * @param \Framework\Router $router
     * 
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Start the application.
     * 
     * @return void
     */
    public function run()
    {
        $router = $this->router;
        require_once __DIR__ . '/../resources/routes.php';
        $router->dispatch($_SERVER);
    }

    /**
     * Get the version number of the Core Framework.
     * 
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }
}
