<?php

namespace ReactExpress\Routing;

/**
 * Class Router
 * @package ReactExpress\Routing
 */
class Router
{

    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var string
     */
    private $path = '';
    /**
     * @var string
     */
    private $method = '';

    /**
     * Router constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $method
     * @param array $arguments
     */
    public function __call(string $method, array $arguments)
    {
        array_unshift($arguments, $method);
        if (count($arguments) == 1) array_unshift($arguments, '/');
        call_user_func_array([$this, 'addRoute'], $arguments);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param $action
     */
    public function addRoute(string $method, string $uri, $action)
    {
        $this->routes[] = new Route($method, $uri, $action);
    }

    /**
     * @param string $path
     * @return Routes
     */
    public function route(string $path)
    {
        return new Routes($this, $path);
    }

    /**
     * @return static
     */
    public function router()
    {
        return new static();
    }

    /**
     * @param string $path
     * @param string $method
     * @return array
     */
    public function match(string $path, string $method)
    {
        $this->path = $path;
        $this->method = $method;
        $middleware = $this->getStack($path, 'USE');
        $all = $this->getStack($path, 'ALL');
        $routes = $this->getStack($path, $method);
        $stack = array_merge($middleware, $all, $routes);
        return $stack;
    }

    /**
     * @param string $path
     * @param string $method
     * @return array
     */
    private function getStack(string $path, string $method)
    {
        $stack = [];
        foreach ($this->routes as $route) {
            if ($match = $route->match($path, $method)) {
                $result = $route->getCallbacks($this->path, $this->method);
                if (is_array($result)) {
                    $stack = array_merge($stack, $result);
                } else {
                    $stack[] = $result;
                }
            }
        }
        return $stack;
    }

}