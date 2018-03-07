<?php

namespace ReactExpress\Core;

/**
 * Class Dispatcher
 * @package ReactExpress\Core
 */
class Dispatcher
{

    /**
     * @var array
     */
    protected $callbacks = array();

    /**
     * @param string $name
     * @param array $params
     * @return mixed|null
     */
    public function run(string $name, array $params = [])
    {
        try {
            return $this->execute($this->get($name), $params);
        } catch (\Exception $e) {

        }
        return null;
    }

    /**
     * @param string $name
     * @param callable $callback
     */
    public function set(string $name, callable $callback)
    {
        $this->callbacks[$name] = $callback;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        return $this->has($name) ? $this->callbacks[$name] : null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->callbacks[$name]);
    }

    /**
     * @param $callback
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    private function execute($callback, array $params = [])
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        } else {
            throw new \Exception('Invalid callback specified.');
        }
    }
}