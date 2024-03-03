<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();

$allCurrencies = $model->getAllCurrencies();
$favourites = $model->fetchFavouriteCurrencies();

if ($allCurrencies === null) {
    echo "Error retrieving currencies.";
    exit;
}

$twig->addGlobal('session', $_SESSION);

echo $twig->render('favourites.html.twig', [
    'favourites' => $favourites,
    'currencies' => $allCurrencies['data']
]);