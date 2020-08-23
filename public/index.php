<?php

ini_set('display_errors', 1);
ini_set('display_starup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Task;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'decima',
    'username'  => 'decima',
    'password'  => 'decima',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
//var_dump($request);
//var_dump($request->getUri()->getPath());

//https://www.digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-16-04
//Crear un mini router
// $route = $_GET['route'] ?? '/';

// if($route == '/')
// {
//     require '../views/index.php';
// }

//Adoptar psr7
//Como funciona los request y response

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

//$map->get('miproyecto', '/miproyecto/', '../views/index.php');
$map->get('miproyecto', '/miproyecto/', [
    'controller' => 'App\Controllers\MainController',
    'action' => 'indexAction'
]);

$map->get('todolist', '/miproyecto/todolist', [
    'controller' => 'App\Controllers\MainController',
    'action' => 'todoListAction'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if(!$route)
{
    echo 'Not found';
}
else
{
    $actionName = $route->handler['action'];
    $controller = new $route->handler['controller'];
    $response = $controller->$actionName($request);
    echo $response->getBody();
    //require $route->handler;
}