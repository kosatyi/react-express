<?php

namespace ReactExpress;

use Exception;
use Closure;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use Psr\Http\Message\ServerRequestInterface;

use ReactExpress\Core\Config;
use ReactExpress\Core\Container;
use ReactExpress\Core\Runner;
use ReactExpress\Routing\Router;
use ReactExpress\Routing\Route;
use ReactExpress\Http\Request;
use ReactExpress\Http\Response;
use ReactExpress\Exception\HaltException;
/**
 * Class Application
 * @package ReactExpress
 * @method Container middleware($name, $class, array $params = array())
 * @method Container method($name, $callback)
 * @method Container load($name, array $params = array())
 * @method Router use(string $path,callable $action = null)
 * @method Router get(string $path,callable $action = null)
 * @method Router post(string $path,callable $action = null)
 * @method Router all(string $path,callable $action = null)
 * @method Router put(string $path,callable $action = null)
 * @method Router delete(string $path,callable $action = null)
 * @method Router head(string $path,callable $action = null)
 * @method Router options(string $path,callable $action = null)
 * @method Router patch(string $path,callable $action = null)
 * @method Router route(string $path)
 * @method Router router()
 */
class Application
{
    /**
     * @var null
     */
    protected static $instance = null;
    /**
     * @var Container
     */
    private $container;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var Runner
     */
    private $runner;
    /**
     * @var Config
     */
    private $config;
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
        $this->runner = new Runner;
        $this->router = new Router;
        $this->container = new Container;
        $this->config    = new Config;
        $this->setup();
    }
    public function setup(){

    }
    /**
     * @param $name
     * @param $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $params);
        }
        if (method_exists($this->container,$name)){
            return call_user_func_array([$this->container, $name], $params);
        }
        return call_user_func_array([$this->router, $name], $params);
    }

    /**
     * @param $port
     * @param $host
     * @param array $cert
     * @return $this
     */
    public function listen($port, $host, array $cert = [])
    {
        $this->runner->handler($this);
        $this->runner->listen($port, $host, $cert);
        return $this;
    }
    /**
     * @return Config
     */
    public function config(){
        return $this->config;
    }

    /**
     * @param ServerRequestInterface $httpRequest
     * @return Promise|PromiseInterface
     * @throws Exception|HaltException
     */
    public function request(ServerRequestInterface $httpRequest)
    {
        $container = $this->container;
        $response  = new Response();
        $request   = new Request($httpRequest);
        $path   = $request->attr('path');
        $method = $request->attr('method');
        $stack  = $this->router->match($path,$method);
        $container->setResponse($response);
        $container->setRequest($request);
        $container->setConfig($this->config());
        try {
            $this->stack($stack);
        } catch (HaltException $e) {
            $this->error($e->getCode(),$e->getMessage());
        }
        return $response->promise();
    }

    /**
     * @param callable $fn
     * @return Closure
     */
    private function next(callable $fn)
    {
        return function (...$args) use ($fn) {
            if ($fn === null) return;
            $fn(...$args);
            $fn = null;
        };
    }
    /**
     * @param array $stack
     * @throws Exception|HaltException
     */
    private function stack(array $stack)
    {
        $index = 0;
        $stack[] = new Route('','',function( $app ){
            $app->halt(404,'Not Found');
        });
        $next = function () use (&$index, &$stack, &$next) {
            if ($index == count($stack)) {
                return;
            }
            $route = $stack[$index++];
            $callback = $this->next(function () use (&$next) {
                $next();
            });
            $this->container->setRoute($route);
            $route->run($this->container, $callback);
        };
        $next();
    }
}