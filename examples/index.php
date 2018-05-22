<?php

require_once '../vendor/autoload.php';

use ReactExpress\Application;

$app = Application::instance();

$app->get('/',function($app){
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('config', $app->config() );
    $app->request->session()->attr('foo','bar');
    $app->response->jsonData();
});

$app->get('/test', function ($app) {
    $app->response->attr('request',$app->request->all());
    $app->response->attr('route',$app->route->all());
    $app->response->attr('session',$app->request->session()->all());
    $app->response->jsonData();
});

$app->listen(9090, '127.0.0.1');
