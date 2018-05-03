<?php

namespace ReactExpress\Core;

use ReactExpress\Exception\HaltException;
use ReactExpress\Http\Request;
use ReactExpress\Http\Response;
use ReactExpress\Routing\Route;

/**
 * Class Container
 * @package ReactExpress\Core
 */
class Container
{
    /**
     * @var Loader
     */
    private $loader;
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var Response
     */
    private $response;
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Route
     */
    private $route;

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
     * @return mixed|null|object|\ReflectionClass
     * @throws HaltException
     * @throws \Exception
     * @throws \ReactExpress\Exception\DispatcherException
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
    }

    /**
     * @param $prop
     * @return mixed
     */
    public function __get( $prop ){
        if( property_exists($this,$prop) ){
            return $this->{$prop};
        }
    }

    /**
     * @param $prop
     * @param $value
     */
    public function __set( $prop , $value ){

    }
    /**
     * @param Route $route
     * @return $this
     */
    public function setRoute(Route $route){
        $this->route = $route;
        return $this;
    }
    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response){
        $this->response = $response;
        return $this;
    }
    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request){
        $this->request = $request;
        return $this;
    }
    /**
     * @param $name
     * @param $class
     * @param array $params
     * @return $this
     */
    public function middleware($name, $class, array $params = array())
    {
        if (!method_exists($this, $name)) {
            $this->loader->register($name, $class, $params);
        }
        return $this;
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
     * @param $name
     * @param array $params
     * @return mixed|null|object|\ReflectionClass
     */
    public function load($name, array $params = array())
    {
        return $this->loader->load($name, $params);
    }
    /**
     * @param int $code
     * @param string $message
     * @throws HaltException
     */
    public function halt(int $code, string $message = '')
    {
        throw new HaltException($message, $code);
    }

}