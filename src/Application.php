<?php

namespace ReactExpress;

use Psr\Http\Message\ServerRequestInterface;

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
        if (method_exists($this->container, $name)) {
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
     * @param ServerRequestInterface $httpRequest
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function request(ServerRequestInterface $httpRequest)
    {
        $container = $this->container;
        $response  = new Response();
        $request   = new Request($httpRequest);
        $path   = $request->attr('path');
        $method = $request->attr('method');
        $stack  = $this->router->match($path, $method);
        $container->setResponse($response);
        $container->setRequest($request);
        try {
            $this->stack($stack);
        } catch (HaltException $e) {
            $response->sendStatus($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            $response->sendStatus(500, 'Server Error');
        }
        return $response->promise();
    }

    /**
     * @param callable $fn
     * @return \Closure
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
     * @throws \Exception|HaltException
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