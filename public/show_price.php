<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

session_start();

$model = new Model();

if (isset($_GET['base_currency']) && isset($_GET['quote_currency'])) {
    $baseCurrency = $_GET['base_currency'];
    $quoteCurrency = $_GET['quote_currency'];
    $price = $model->getCurrencyPairPrice($baseCurrency, $quoteCurrency);

    echo "{$price['data']['amount']}";
}

if (isset($_POST['action']) && in_array($_POST['action'], ['favorite_add', 'favorite_remove'])) {
    if (!isset($_SESSION['logged_in_as'])) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }
    $user_id = $_SESSION['logged_in_as'];

    $currencyName = $_POST['currency'];
    if ($_POST['action'] == 'favorite_add') {
        $model->addOrUpdateFavouriteCurrency($currencyName, $user_id);
    } else if ($_POST['action'] == 'favorite_remove') {
        $model->removeFavouriteCurrency($currencyName, $user_id);
    }

    $favourites = $model->fetchFavouriteCurrencies($user_id);
    echo json_encode($favourites);
    exit;
}