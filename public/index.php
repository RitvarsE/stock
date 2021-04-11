<?php
require_once "../vendor/autoload.php";

use App\Controllers\HomeController;
use App\Repositories\Finnhub\FinnhubRepository;
use App\Repositories\Users\MySQLUsersRepository;
use App\Repositories\Users\UsersRepository;
use App\Services\Main\MainService;
use App\Services\Twig\TwigService;
use App\Services\Users\UsersService;
session_start();
//Container
$container = new League\Container\Container;
$container->add(FinnhubRepository::class, FinnhubRepository::class);
$container->add(TwigService::class, TwigService::class);
$container->add(UsersRepository::class, MySQLUsersRepository::class);
$container->add(UsersService::class, UsersService::class)->addArgument(UsersRepository::class);
$container->add(MainService::class, MainService::class)
    ->addArguments([FinnhubRepository::class, TwigService::class, UsersService::class]);
$container->add(HomeController::class, HomeController::class)->addArgument(MainService::class);


//Routes
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute(['GET'], '/', [HomeController::class, 'login']);
    $r->addRoute(['POST'], '/', [HomeController::class, 'index']);
    $r->addRoute(['GET'], '/register', [HomeController::class, 'register']);
    $r->addRoute(['POST'], '/register', [HomeController::class, 'registered']);
    $r->addRoute(['GET'], '/account', [HomeController::class, 'account']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        echo ($container->get($controller))->$method($vars);
        break;
}