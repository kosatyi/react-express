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
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public function __call(string $name, array $params = [])
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this,$name],$params);
        } else {
            $this->createRoute($name, ...$params);
        }
        return $this;
    }
    /**
     * @param string $method
     * @param mixed ...$params
     * @return $this
     */
    private function createRoute(string $method, ...$params){
        if (count($params) == 1) array_unshift($params, '/');
        $this->routes[] = new Route( $method , ...$params );
        return $this;
    }
    /**
     * @param string $path
     * @return Routes
     */
    public function route(string $path)
    {
        return new Routes($this,$path);
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