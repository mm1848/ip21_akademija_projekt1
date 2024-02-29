<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();

$allCurrencies = $model->getAllCurrencies();
/*$favourites = $model->fetchFavouriteCurrencies();*/

if ($allCurrencies === null) {
    echo "Error retrieving currencies.";
    exit;
}

/*echo $twig->render('favourites.html.twig', ['favourites' => $favourites]);*/

echo $twig->render('select_currencies.html.twig', ['currencies' => $allCurrencies['data']]);




