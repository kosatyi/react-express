<?php

namespace ReactExpress\Core;

/**
 * Class Controller
 * @package ReactExpress\Core
 */
class Controller
{
    /**
     * @var Container
     */
    protected Container $app;
    /**
     * @var callable
     */
    protected $next;
    final public function __construct(Container $app,callable $next)
    {
        $this->app  = $app;
        $this->next = $next;
    }
    final public function exists($name): bool
    {
        return method_exists($this, $name);
    }
    final public function call($method, $params = [])
    {
        return call_user_func_array([$this, $method], $params);
    }
    final public function next()
    {
        $next = $this->next;
        if(is_callable($next)){
            $next();
        }
    }
}