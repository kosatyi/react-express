<?php

namespace ReactExpress\Routing;

/**
 * Class Routes
 * @package ReactExpress\Routing
 */
class Routes
{

    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $path;

    /**
     * Routes constructor.
     * @param Router $router
     * @param string $path
     */
    public function __construct(Router $router, string $path)
    {
        $this->router = $router;
        $this->path = $path;
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return $this
     */
    public function __call(string $method, array $arguments = [])
    {
        array_unshift($arguments, $this->path);
        call_user_func_array([$this->router, $method], $arguments);
        return $this;
    }

}