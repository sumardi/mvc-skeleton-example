<?php

namespace Framework;

use Framework\Exceptions\HttpNotFoundException;
use Framework\Exceptions\MethodNotFoundException;

class Router
{
    /**
     * Array of routes
     * 
     * @var array
     */
    protected $routes = [];

    /**
     * Get default namespace for controllers.
     * 
     * @var string
     */
    protected $namespace = 'App\\Controllers\\';

    /**
     * Create new route
     * 
     * @param string $method
     * @param string $uri
     * @param array $action
     * 
     * @return void
     */
    protected function add($method, $uri, $action)
    {
        $uri = preg_replace('/\//', '\\/', $uri);

        // Create group for ":parameter"
        $allowedParamChars = '[a-zA-Z0-9]+';
        $uri = preg_replace(
            '/:(' . $allowedParamChars . ')/', # Replace :parameter
            '(?<$1>' . $allowedParamChars . ')', # with (?<parameter>[a-zA-Z0-9]+)
            $uri
        );

        $uri = '/^' . $uri . '$/i';

        $this->routes[$method][$uri] = $action;
    }

    /**
     * Match the route to the routes table.
     * Return route pattern & parameters if a route is found.
     * 
     * @param string $method
     * @param string $uri
     * 
     * @return array
     */
    public function match($method, $uri)
    {
        foreach ($this->getRoutes($method) as $pattern => $params) {
            if (preg_match($pattern, $uri, $matches)) {
                return array(['pattern' => $pattern, 'params' => $params]);
            }
        }
    }

    /**
     * Add new route to the GET group.
     * 
     * @param string $uri
     * @param string $action
     * 
     * @return void
     */
    public function get($uri, $action)
    {
        $this->add('GET', $uri, $action);
    }

    /**
     * Add new route to the POST group.
     * 
     * @param string $uri
     * @param string $action
     * 
     * @return void
     */
    public function post($uri, $action)
    {
        $this->add('POST', $uri, $action);
    }

    /**
     * Remove query string variables from the URL.
     * 
     * @return string
     */
    public function removeQueryStringVariables($uri)
    {
        if ($uri != '') {
            $parts = explode('?', $uri);

            $uri = $parts[0];
        }

        return $uri;
    }

    /**
     * Dispatch the route, creating the controller object 
     * and running the action method.
     * 
     * @param string $request
     * 
     * @return void
     */
    public function dispatch($request)
    {
        $url = $this->removeQueryStringVariables($request['REQUEST_URI']);
        $method = $request['REQUEST_METHOD'];

        if ($params = $this->match($method, $url)) {
            $namespace = isset($params[0]['params']['namespace']) ? $params[0]['params']['namespace'] . '\\' : '';
            $controller = $namespace . $params[0]['params']['controller'] . 'Controller';
            $action = $params[0]['params']['action'];
            $paramaters = $this->compileParameterNames($params[0]['pattern'], $url);

            if (is_null($action) || empty($action)) {
                throw new \Exception('Action cannot be null.');
            }

            $className = $this->namespace . $controller;
            $controller_object = new $className;

            try {
                $response = call_user_func_array([$controller_object, $action], $paramaters);
            } catch (\ErrorException $e) {
                throw new MethodNotFoundException(sprintf('Method `%s` in controller `%s` cannot be found.', $action, $className));
            }
        } else {
            throw new HttpNotFoundException(sprintf('No route matched'), 404);
        }
    }

    /**
     * Get the route parameter names.
     * For example:
     * From URI /something/:name into [name => value]
     * 
     * @param string $pattern
     * @param string $url
     * 
     * @return array
     */
    public function compileParameterNames($pattern, $url)
    {
        // (pattern, url, matches)
        preg_match($pattern, $url, $matches);

        // :parameter convert to [parameter => 'value']       
        return $this->parameters = array_intersect_key(
            $matches,
            array_flip(array_filter(array_keys($matches), 'is_string'))
        );
    }

    /**
     * Return routes for the given method (GET or POST).
     * 
     * @param string $method
     * 
     * @return array
     */
    public function getRoutes($method)
    {
        return $this->routes[$method];
    }
}
