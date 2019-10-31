<?php

namespace ReactExpress\Core;

use Exception;
use ReactExpress\Exception\DispatcherException;
use ReactExpress\Exception\HaltException;

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
     * @throws Exception|DispatcherException|HaltException
     */
    public function run(string $name, array $params = [])
    {
        try {
            return $this->execute($this->get($name), $params);
        } catch (DispatcherException $e) {

        }
        return null;
    }

    /**
     * @param string $name
     * @param callable $callback
     */
    public function set(string $name, callable $callback): void
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
    public function has(string $name): bool
    {
        return isset($this->callbacks[$name]);
    }

    /**
     * @param $callback
     * @param array $params
     * @return mixed
     * @throws DispatcherException
     */
    private function execute($callback, array $params = [])
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }
        throw new DispatcherException('Invalid callback specified.');
    }
}