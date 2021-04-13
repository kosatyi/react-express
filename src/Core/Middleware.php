<?php

namespace ReactExpress\Core;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ReactExpress\Application;
/**
 * Class Middleware
 * @package ReactExpress\Core
 */
class Middleware
{
    protected $run;
    protected $app;
    /**
     * Middleware constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->prepare();
    }
    /**
     *
     */
    protected function prepare(): void
    {

    }
    /**
     * @param ServerRequestInterface $request
     * @param callable|null $next
     * @return mixed
     */
    protected function callback(ServerRequestInterface $request, callable $next)
    {
        return $next( $request );
    }
    /**
     * @param ServerRequestInterface $request
     * @param callable|null $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $run = $this->run;
        if( is_callable( $run ) ) {
            $callback = function( $request  ) use( $next ){
                return $this->callback( $request , $next );
            };
            return $run( $request , $callback );
        }
        return $next;
    }
}