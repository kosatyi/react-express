<?php

namespace ReactExpress\Core;
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
    protected function callback(ServerRequestInterface $request, callable $next = null)
    {
        return $next();
    }
    /**
     * @param ServerRequestInterface $request
     * @param callable|null $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, callable $next = null)
    {
        $run = $this->run;
        return $this->callback($request,static function() use($request,$run,$next){
            if( is_callable($run) ){
                return $run($request,$next);
            }
        });
    }
}