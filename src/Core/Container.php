<?php

namespace ReactExpress\Core;

use Exception;
use ReactExpress\Exception\DispatcherException;
use ReactExpress\Exception\HaltException;
use ReactExpress\Http\Request;
use ReactExpress\Http\Response;
use ReactExpress\Routing\Route;
use ReflectionClass;

/**
 * Class Container
 * @package ReactExpress\Core
 * @method void error($code,$message)
 * @property Response $response
 * @property Request $request
 * @property Route $route
 * @property Config $config
 * @property Loader $loader
 * @property Dispatcher $dispatcher
 */
class Container
{
    /**
     * @var Loader
     */
    private Loader $loader;
    /**
     * @var Dispatcher
     */
    private Dispatcher $dispatcher;

    /**
     * @var Response
     */
    private Response $response;
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Route
     */
    private Route $route;
    /**
     * @var Config
     */
    private Config $config;
    /**
     * Container constructor.
     */
    public function __construct()
    {
        $this->loader     = new Loader;
        $this->dispatcher = new Dispatcher;
    }
    /**
     * @param $name
     * @param $params
     * @return mixed|null|object|ReflectionClass
     * @throws HaltException
     * @throws Exception
     * @throws DispatcherException
     */
    public function __call($name, $params)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this,$name],$params);
        }
        if ($this->dispatcher->has($name)) {
            array_unshift($params, $this);
            return $this->dispatcher->run($name, $params);
        }
        if ($this->loader->get($name)) {
            return $this->loader->load($name);
        }
        return null;
    }
    /**
     * @param $prop
     * @return mixed
     */
    public function __get( $prop )
    {
        if( property_exists($this,$prop) ){
            return $this->{$prop};
        }
        return null;
    }
    /**
     * @param $prop
     * @param $value
     */
    public function __set( $prop , $value ){

    }
    /**
     * @param $prop
     * @return bool
     */
    public function __isset( $prop )
    {
        return false;
    }
    /**
     * @return Config
     */
    public function config(): Config
    {
        return $this->config;
    }
    /**
     * @param Route $route
     * @return $this
     */
    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }
    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config): self
    {
        $this->config = $config;
        return $this;
    }
    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;
        return $this;
    }
    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }
    /**
     * @param $name
     * @param $class
     * @param array $params
     * @return $this
     */
    public function register($name, $class, array $params = []): self
    {
        if (!method_exists($this, $name)) {
            $this->loader->register($name, $class, $params);
        }
        return $this;
    }
    /**
     * @param $name
     * @param $callback
     * @return Container
     */
    public function method($name, $callback): self
    {
        if (!method_exists($this, $name)) {
            $this->dispatcher->set($name, $callback);
        }
        return $this;
    }
    /**
     * @param $name
     * @param array $params
     * @return mixed|null|object|ReflectionClass
     */
    public function load($name, array $params = [])
    {
        return $this->loader->load($name, $params);
    }
    /**
     * @param int $code
     * @param string $message
     * @throws HaltException
     */
    public function halt(int $code, string $message = ''): void
    {
        throw new HaltException($message, $code);
    }
}