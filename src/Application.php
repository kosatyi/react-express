<?php

namespace ReactExpress;

use Psr\Http\Message\ServerRequestInterface;

use ReactExpress\Core\Dispatcher;
use ReactExpress\Core\Server;
use ReactExpress\Core\Loader;

use ReactExpress\Routing\Router;
use ReactExpress\Routing\Route;

use ReactExpress\Http\Request;
use ReactExpress\Http\Response;

/**
 * Class Application
 * @package ReactExpress
 */
class Application
{

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @var Router
     */
    private $router;
    /**
     * @var Server
     */
    private $server;

    /**
     * @var
     */
    public $template;
    /**
     * @var
     */
    public $request;
    /**
     * @var
     */
    public $response;
    /**
     * @var
     */
    public $route;

    /**
     * @var Loader
     */
    protected $loader;
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @return null|static
     */
    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->loader = new Loader;
        $this->dispatcher = new Dispatcher;
        $this->server = new Server;
        $this->router = new Router;
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {

    }

    /**
     * @param $key
     */
    public function __get($key)
    {

    }

    /**
     * @param $name
     * @param $params
     * @return mixed|null|object|\ReflectionClass
     */
    public function __call($name, $params)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $params);
        } else if ($this->dispatcher->has($name)) {
            array_unshift($params, $this);
            return $this->dispatcher->run($name, $params);
        } else if ($this->loader->get($name)) {
            return $this->loader->load($name);
        } else {
            return call_user_func_array([$this->router, $name], $params);
        }
    }

    /**
     * @param $name
     * @param $class
     * @param array $params
     * @return $this
     */
    public function middleware($name, $class, array $params = array())
    {
        $this->loader->register($name, $class, $params);
        return $this;
    }

    /**
     * @param $name
     * @param array $params
     * @return mixed|null|object|\ReflectionClass
     */
    public function load($name, array $params = array())
    {
        return $this->loader->load($name, $params);
    }

    /**
     * @param $name
     * @param $callback
     */
    public function method($name, $callback)
    {
        if (!method_exists($this, $name)) {
            $this->dispatcher->set($name, $callback);
        }
    }

    /**
     * @param $port
     * @param $host
     * @param array $cert
     * @return $this
     */
    public function listen($port, $host, array $cert = [])
    {
        $this->server->handler($this);
        $this->server->listen($port, $host, $cert);
        return $this;
    }

    /**
     * @param ServerRequestInterface $httpRequest
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function request(ServerRequestInterface $httpRequest)
    {
        $this->response = new Response();
        $this->request  = new Request($httpRequest);
        $path = $this->request->attr('path');
        $method = $this->request->attr('method');
        $stack = $this->router->match($path, $method);
        $this->stack($stack);
        return $this->response->promise();
    }

    /**
     * @param $fn
     * @return \Closure
     */
    private function next($fn)
    {
        return function (...$args) use ($fn) {
            if ($fn === null) return;
            $fn(...$args);
            $fn = null;
        };
    }

    /**
     * @param array $stack
     */
    private function stack(array $stack)
    {
        $index = 0;
        $stack[] = new Route('', '', function () {
            $this->response->sendStatus(404);
        });
        $next = function () use (&$index, &$stack, &$next) {
            if ($index == count($stack)) {
                return;
            }
            $this->route = $stack[$index++];
            $callback = $this->next(function () use (&$next) {
                $next();
            });
            $this->route->run($this, $callback);
        };
        $next();
    }

}