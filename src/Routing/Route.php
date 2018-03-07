<?php

namespace ReactExpress\Routing;

use ReactExpress\Application;
use ReactExpress\Core\Model;
use ReactExpress\Util\PathToRegexp;

/**
 * Class Route
 * @package ReactExpress\Routing
 */
class Route extends Model
{

    /**
     * @var array
     */
    private static $options = [
        'USE' => [
            'sensitive' => true,
            'strict' => false,
            'end' => false
        ],
        'DEFAULT' => [
            'sensitive' => true,
            'strict' => false,
            'end' => true
        ]
    ];

    /**
     * @var
     */
    private $regex;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @var
     */
    private $action;

    /**
     * @var array
     */
    private $keys = [];

    /**
     * Route constructor.
     * @param string $method
     * @param string $path
     * @param $action
     */
    public function __construct(string $method, string $path, $action)
    {
        $this->method = strtoupper($method);
        $this->path = $path;
        $this->action = $action;
        $this->parse();
    }

    /**
     * @param Application $app
     * @param callable $next
     */
    public function run(Application $app, callable $next)
    {
        if (is_callable($this->action)) {
            call_user_func_array($this->action, [$app, $next]);
        } else {
            $next();
        }
    }

    /**
     * @return bool
     */
    public function isRouter()
    {
        return $this->action instanceof Router;
    }

    /**
     * @param string $path
     * @return null|string|string[]
     */
    public function getSubPath(string $path = '')
    {
        return preg_replace($this->regex, '', $path);
    }

    /**
     * @param string $path
     * @return Route
     */
    private function withParams(string $path = '')
    {
        $route = clone $this;
        $route->params($path);
        return $route;
    }

    /**
     * @param string $path
     * @param string $method
     * @return Route
     */
    public function getCallbacks(string $path, string $method)
    {
        if ($this->isRouter()) {
            $path = $this->getSubPath($path);
            $stack = $this->action->match($path, $method);
        } else {
            $stack = $this->withParams($path);
        }
        return $stack;
    }

    /**
     * @return mixed
     */
    private function getRegexOptions()
    {
        $options = $this::$options;
        $method = $this->method;
        return isset($options[$method]) ? $options[$method] : $options['DEFAULT'];
    }

    /**
     *
     */
    public function parse()
    {
        $this->keys = [];
        $this->regex = PathToRegexp::convert(
            $this->path,
            $this->keys,
            $this->getRegexOptions()
        );
    }

    /**
     * @param string $path
     */
    public function params(string $path)
    {
        $data = PathToRegexp::match($this->regex, $path);
        $keys = $this->keys;
        $len = count($data);
        for ($i = 1; $i < $len; $i++) {
            $key = $keys[$i - 1];
            $prop = $key['name'];
            $this->attr($prop, $data[$i]);
        }
    }

    /**
     * @param string $path
     * @param string $method
     * @return bool
     */
    public function match(string $path, string $method)
    {
        if (strtoupper($method) !== strtoupper($this->method)) {
            return FALSE;
        }
        return is_array(PathToRegexp::match($this->regex, $path));
    }

}