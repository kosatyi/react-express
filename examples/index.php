<?php

require_once '../vendor/autoload.php';

use App\Controller\Dashboard;

use ReactExpress\Application;
use ReactExpress\Core\Container;
use ReactExpress\Middleware\Session;

$app = Application::instance();

$app->server()->middleware(Session::class);

$app->use(static function(Container $app, $next){
    $app->session()->start();
    $next();
});

$config = $app->config();

$config->set('cookie.expiration',7200);
$config->set('cookie.domain','reactexpress.dev.io');
$config->set('cookie.path','/');
$config->set('cookie.secure',false);
$config->set('cookie.httponly',true);

$app->method('error',static function(Container $app,$code,$message){

    $app->response->send(sprintf('%s - %s',$code,$message));

});

$app->method('render',static function(Container $app,$template,$data=[]){

});

$app->controller('/admin' , Dashboard::class );

$dashboard = $app->router();

$dashboard->use(static function(Container $app,$next){
    $app->response->write('set dashboard permission<br>');
    $next();
});

$dashboard->get('/',static function(Container $app,$next){
    $app->response->send('dashboard');
});

$dashboard->get('/admin',static function(Container $app,$next){
    $app->response->send('dashboard admin');
});

$app->use('/dashboard',$dashboard);

$app->use('/dashboard/:path(.+)' , static function(Container $app, $next){
    $app->response->attr('route', $app->route->all() );
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
    $next();
});

$app->get('/',static function( Container $app ){
    $app->session()->attr('foo','bar');
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->response->attr('session', $app->session()->all() );
    $app->response->jsonData();
});

$app->get('/dashboard/:module?/:category?/:page?',static function ( Container $app ) {
    $app->response->attr('request', $app->request->all() );
    $app->response->attr('route', $app->route->all() );
    $app->response->attr('config', $app->config() );
    $app->response->attr('session', $app->session()->all() );
    $app->response->jsonData();
});

$app->get('/:date(\d{10})-:alias([\w-]+)',static function ( Container $app ) {
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
});

$app->server()->listen(9095);