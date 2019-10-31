<?php

namespace ReactExpress\Core;


use Exception;
use ReflectionClass;

/**
 * Class Loader
 * @package ReactExpress\Core
 */
class Loader
{

    /**
     * @var array
     */
    protected $classes = [];

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @param string $name
     * @param $class
     * @param array $params
     * @param callable|null $callback
     */
    public function register(string $name, $class , array $params = [] , callable $callback = null): void
    {
        unset($this->instances[$name]);
        $this->classes[$name] = [$class, $params, $callback];
    }

    /**
     * @param $name
     */
    public function unregister($name): void
    {
        unset($this->classes[$name]);
    }

    /**
     * @param $name
     * @param array|null $arguments
     * @return mixed|null|object|ReflectionClass
     */
    public function load($name, array $arguments = null)
    {
        $instance = null;
        if ($class = $this->get($name)) {
            $exists = isset($this->instances[$name]);
            $shared = $arguments === null;
            [$class, $params, $callback] = $class;
            if ($shared) {
                if ($exists) {
                    $instance = $this->getInstance($name);
                } else {
                    $instance = $this->newInstance($class, $params);
                    $this->instances[$name] = $instance;
                }
            } else {
                $instance = $this->newInstance($class, $arguments);
            }
            if ($callback && (!$shared || !$exists)) {
                call_user_func_array($callback, [&$instance]);
            }
        }
        return $instance;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getInstance($name)
    {
        return $this->instances[$name] ?? null;
    }
    /**
     * @param $class
     * @param array $params
     * @return mixed|null|object|ReflectionClass
     */
    public function newInstance($class, array $params = [])
    {
        if (is_callable($class)) {
            return call_user_func_array($class, $params);
        }
        try {
            $class = new ReflectionClass($class);
            $class = $class->newInstanceArgs($params);
        } catch (Exception $e) {
            $class = null;
        }
        return $class;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return $this->classes[$name] ?? null;
    }

    /**
     *
     */
    public function reset(): void
    {
        $this->classes = [];
        $this->instances = [];
    }

}