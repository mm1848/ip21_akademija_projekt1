<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../lib/model.php';

$model = new Model();

if (isset($_GET['base_currency']) && isset($_GET['quote_currency'])) {
    $baseCurrency = $_GET['base_currency'];
    $quoteCurrency = $_GET['quote_currency'];
    $price = $model->getCurrencyPairPrice($baseCurrency, $quoteCurrency);

    echo "{$price['data']['amount']}";
}

if (isset($_POST['action']) && in_array($_POST['action'], ['favorite_add', 'favorite_remove'])) {
    $currencyName = $_POST['currency'];
    if ($_POST['action'] == 'favorite_add') {
        $model->addOrUpdateFavouriteCurrency($currencyName);
    } else if ($_POST['action'] == 'favorite_remove') {
        $model->removeFavouriteCurrency($currencyName);
    }

    // Vrnite posodobljen seznam priljubljenih
    $favourites = $model->fetchFavouriteCurrencies();
    echo json_encode($favourites);
    exit;
}