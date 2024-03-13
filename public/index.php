<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../lib/view/web');
$twig = new Twig\Environment($loader);

$model = new Model();

$twig->addGlobal('session', $_SESSION);

$allCurrencies = $model->getAllCurrencies();
if ($allCurrencies === null) {
    echo "Error retrieving currencies.";
    exit;
}

if (isset($_SESSION['logged_in_as'])) {
    $user_id = $_SESSION['logged_in_as'];
    $favourites = $model->fetchFavouriteCurrencies($user_id);
} else {
    $favourites = [];
}

echo $twig->render('favourites.html.twig', [
    'favourites' => $favourites,
    'currencies' => $allCurrencies['data']
]);


