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
     * @param $port
     * @param string $host
     * @param array $cert
     */
    public function listen($port, $host = '127.0.0.1', $cert = [])
    {
        $loop    = Factory::create();
        $cache   = new ArrayCache();
        $session = new SessionMiddleware('session' , $cache , [0,'/','',false,false] );
        $handler = function (ServerRequestInterface $request) {
            return $this->app->request($request);
        };
        $http = new HttpServer([$session, $handler]);
        $socket = new SocketServer("{$host}:{$port}", $loop);
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