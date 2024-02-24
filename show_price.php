<?php
require_once 'vendor/autoload.php';
require_once 'lib/model.php';

$model = new Model();

if (isset($_GET['base_currency']) && isset($_GET['quote_currency'])) {
    $baseCurrency = $_GET['base_currency'];
    $quoteCurrency = $_GET['quote_currency'];
    $price = $model->getCurrencyPairPrice($baseCurrency, $quoteCurrency);

    echo "{$price['data']['amount']}";
} else {
    echo "Please select both base and quote currencies.";
}
