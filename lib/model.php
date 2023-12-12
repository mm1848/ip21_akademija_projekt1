<?php

const API_BASE_URL = 'https://api.coinbase.com/v2/';
$validCurrencies = getValidCurrencies(); 

function callApi($path, $params = '') {
    $url = API_BASE_URL . $path . $params;
    $json_data = file_get_contents($url);
    $data = json_decode($json_data, true);

    if ($data === null || !isset($data['data'])) {
        return false;
    }
    
    return $data;
}

function getValidCurrencies() {
    $valid_currencies_data = callApi('currencies');

    if ($valid_currencies_data === false || !isset($valid_currencies_data['data']) || !is_array($valid_currencies_data['data'])) {
        return false;
    }

    return array_column($valid_currencies_data['data'], 'id');
}

function getCurrencyPrice($currency_symbol) {
    $data = callApi("prices/$currency_symbol-USD/spot");

    if ($data === false || !isset($data['data']['amount'])) {
        return false;
    }

    return $data['data']['amount'];
}

function getCurrencyPairPrice($base_currency, $quote_currency) {
    $data = callApi("prices/$base_currency-$quote_currency/spot");

    if ($data === false || !isset($data['data']['base'], $data['data']['amount'], $data['data']['currency'])) {
        return false;
    }

    return [
        'base' => $data['data']['base'],
        'amount' => $data['data']['amount'],
        'currency' => $data['data']['currency'],
    ];
}