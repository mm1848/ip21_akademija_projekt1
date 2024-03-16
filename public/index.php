<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

use League\Route\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();
$twig->addGlobal('session', $_SESSION);

$router = new Router;

$router->map('GET', '/about', function ($request) use ($twig) {
    return new Response\HtmlResponse($twig->render('about.twig'));
});

$router->map('GET', '/list', function ($request) use ($twig, $model) {
    $allCurrencies = $model->getAllCurrencies();
    if ($allCurrencies === null) {
        return new Response\HtmlResponse("Error retrieving currencies.", 500);
    }
    return new Response\HtmlResponse($twig->render('list.html.twig', ['currencies' => $allCurrencies['data']]));
});

$router->map('GET', '/', function ($request) use ($twig, $model) {

    $allCurrencies = $model->getAllCurrencies();
    $favourites = [];
    if (isset($_SESSION['logged_in_as'])) {
        $user_id = $_SESSION['logged_in_as'];
        $favourites = $model->fetchFavouriteCurrencies($user_id);
    }
    return new Response\HtmlResponse($twig->render('favourites.html.twig', [
        'favourites' => $favourites,
        'currencies' => $allCurrencies['data']
    ]));
});

$request = ServerRequestFactory::fromGlobals();
$response = $router->dispatch($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
