<?php

require_once 'vendor/autoload.php';
require_once 'lib/model.php';

$loader = new Twig\Loader\FilesystemLoader('lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();

$favourites = $model->fetchFavouriteCurrencies();

if (!empty($favourites)) {
    echo $twig->render('favourites.html.twig', ['favourites' => $favourites]);
} else {
    echo "No favourite currencies found.";
}

$validCurrencies = $model->getValidCurrencies();
echo $twig->render('list.html.twig', ['currencies' => $validCurrencies['data']]);


