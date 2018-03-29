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
     * @var array
     */
    private $methods = [
        'use',
        'all',
        'get',
        'post',
        'head',
        'put',
        'delete',
        'connect',
        'options',
        'patch'
    ];


    public function has(string $method)
    {
        return in_array($method, $this->methods);
    }


    public function __call(string $name,array $params = [])
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $params);
        }
        if (count($params) == 1) array_unshift($params, '/');
        $this->routes[] = new Route($name, $params[0], $params[1]);
    }

    public function route(string $path)
    {
        return new Routes($this, $path);
    }

    public function router()
    {
        return new static();
    }

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