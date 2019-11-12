<?php

namespace ReactExpress\Core;
use React\EventLoop\Factory;
use React\Socket\Server as SocketServer;
use React\Socket\SecureServer as SecureSocketServer;
use React\Http\Server as HttpServer;
use ReactExpress\Application;
use Psr\Http\Message\ServerRequestInterface;
/**
 * Class Server
 * @package ReactExpress\Core
 */
class Server
{
    /**
     * @var Application
     */
    private $app;
    private $loader;
    private $certificate = [];
    private $middleware  = [];
    public function __construct()
    {
        $this->loader = new Loader();
    }
    /**
     * @param Application|null $app
     * @return $this
     */
    public function handler(Application $app = null): self
    {
        $this->app = $app;
        return $this;
    }
    public function middleware( string $class = '' ): self
    {
        $this->middleware[] = $this->loader->newInstance($class,[$this->app]);
        return $this;
    }
    public function application(): callable
    {
        return function (ServerRequestInterface $request) {
            return $this->app->request($request);
        };
    }
    public function certificate( $certificate = []): void
    {
        $this->certificate = $certificate;
    }
    /**
     * @param $port
     * @param string $host
     */
    public function listen( $port , $host = '127.0.0.1'): void
    {
        $loop = Factory::create();
        $socket = new SocketServer("{$host}:{$port}", $loop);
        if (count($this->certificate) > 0) {
            $socket = new SecureSocketServer($socket, $loop, $this->certificate);
        }
        $middleware   = $this->middleware;
        $middleware[] = $this->application();
        $http = new HttpServer($middleware);
        $http->on('error', static function ($error) {
            var_dump($error);
        });
        $http->listen($socket);
        echo("Server running on {$host}:{$port}\n");
        $loop->run();
    }
}