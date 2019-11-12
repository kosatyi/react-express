<?php

require_once '../vendor/autoload.php';

use ReactExpress\Application;
use ReactExpress\Core\Container;
use ReactExpress\Middleware\Session;

$app = Application::instance();

$config = $app->config();

$config->set('cookie.expiration',7200);
$config->set('cookie.domain','');
$config->set('cookie.path','/');
$config->set('cookie.secure',true);
$config->set('cookie.httponly',true);

$app->method('error',static function($app,$code,$message){
    $app->response->send(sprintf('%s - %s',$code,$message));
});

$app->method('render',static function($app,$template,$data=[]){

});

$app->use(static function(Container $app, $next){
    $session = $app->request->attr('session');
    $session->start();
    $next();
});

$app->get('/',static function( Container $app ){
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
});

$app->get('/:date(\d{10})-:alias([\w-]+)',static function ( Container $app ) {
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
});

$app->get('/dashboard/:module?/:category?/:page?',static function ( Container $app ) {
    $app->response->attr('request', $app->request->all() );
    $app->response->attr('route', $app->route->all() );
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
});

$app->server()->middleware(Session::class);

$app->server()->listen(9095);