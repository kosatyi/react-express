<?php

require_once '../vendor/autoload.php';

use ReactExpress\Application;

use ReactExpress\Core\Container;

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

$app->get('/',static function( Container $app ){
    $app->request->session()->attr('foo','bar');
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->response->attr('session', $app->request->session()->all() );
    $app->response->jsonData();
});

$app->get('/dashboard/:module?/:category?/:page?',static function ( Container $app ) {
    $app->response->attr('request', $app->request->all() );
    $app->response->attr('route', $app->route->all() );
    $app->response->attr('session', $app->request->session()->all() );
    $app->response->attr('config', $app->config() );
    $app->response->jsonData();
});

$router = $app->router();

$app->listen(9095, '127.0.0.1');