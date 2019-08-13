<?php

require __DIR__ . '/../vendor/autoload.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use App\Controller\MainController;
use App\Service\ExceptionService;

// Глобальный обработчик исключений
set_exception_handler([ExceptionService::class, 'handleGlobal']);

session_start();

// Роутер для обработки запросов
$router = new RouteCollector();
$router->controller('/', MainController::class);

// Диспатчер
$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

echo $response;