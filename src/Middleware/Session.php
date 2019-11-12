<?php

namespace ReactExpress\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use React\Cache\ArrayCache;
use ReactExpress\Core\Middleware;
use WyriHaximus\React\Http\Middleware\SessionMiddleware;

class Session extends Middleware
{

    protected function callback(ServerRequestInterface $request, callable $next = null)
    {
        return $next();
    }

    protected function prepare(): void
    {
        $config = $this->app->config();
        $this->run = new SessionMiddleware( $config->get('cookie.name', 'session') , new ArrayCache(),[
            $config->get('cookie.expiration', 7200),
            $config->get('cookie.path', '/'),
            $config->get('cookie.domain', ''),
            $config->get('cookie.secure', true),
            $config->get('cookie.httponly', true)
        ]);
    }
}
