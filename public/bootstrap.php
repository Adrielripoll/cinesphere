<?php

use app\controllers\GetMoviesController;
use app\controllers\CreateFavoriteController;
use app\controllers\GetFavoriteListController;
use app\controllers\FavoriteWatchedController;
use app\controllers\DeleteFavoriteController;

use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->get('/movies/{page}', [GetMoviesController::class, 'execute']);
$app->post('/favorites', [CreateFavoriteController::class, 'execute']);
$app->get('/favorites', [GetFavoriteListController::class, 'execute']);
$app->put('/favorites/{id}', [FavoriteWatchedController::class, 'execute']);
$app->delete('/favorites/{id}', [DeleteFavoriteController::class, 'execute']);

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();
