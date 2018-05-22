<?php

namespace ReactExpress\Core;

use React\EventLoop\Factory;
use React\Socket\Server as SocketServer;
use React\Socket\SecureServer as SecureSocketServer;
use React\Http\Server as HttpServer;

use React\Cache\ArrayCache;

use Psr\Http\Message\ServerRequestInterface;

use ReactExpress\Application;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;

/**
 * Class Server
 * @package ReactExpress\Core
 */
class Runner
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @param Application|null $app
     * @return $this
     */
    public function handler(Application $app = null)
    {
        $this->app = $app;
        return $this;
    }

    /**
     * @return SessionMiddleware
     */
    private function session(){
        $config  = $this->app->config();
        $name    = $config->get('cookie.name','session');
        $cache   = new ArrayCache();
        $session = new SessionMiddleware($name,$cache,[
            $config->get('cookie.expiration',7200),
            $config->get('cookie.path','/'),
            $config->get('cookie.domain',''),
            $config->get('cookie.secure',false),
            $config->get('cookie.httponly',false)
        ]);
        return $session;
    }
    /**
     * @return \Closure
     */
    private function application(){
        $handler = function (ServerRequestInterface $request) {
            return $this->app->request($request);
        };
        return $handler;
    }
    /**
     * @param $port
     * @param string $host
     * @param array $cert
     */
    public function listen($port, $host = '127.0.0.1', $cert = [])
    {
        $loop    = Factory::create();
        $session = $this->session();
        $handler = $this->application();
        $http    = new HttpServer([$session,$handler]);
        $socket  = new SocketServer("{$host}:{$port}", $loop);
        if (count($cert) > 0) {
            $socket = new SecureSocketServer($socket, $loop, $cert);
        }
        $http->on('error', function ($error) {
            var_dump($error);
        });
        $http->listen($socket);
        echo("Server running on {$socket->getAddress()}\n");
        $loop->run();
    }

}