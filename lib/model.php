<?php

class Model {
    const API_BASE_URL = 'https://api.coinbase.com/v2/';
    //$validCurrencies = getValidCurrencies();
    private function callApi($path, $params = '') {
        $url = self::API_BASE_URL . $path . $params;
        $json_data = file_get_contents($url);
        $data = json_decode($json_data, true);

        if ($data === null || !isset($data['data'])) {
            return false;
        }
        
        return $data;
    }

    public function fetchData($path, $params = '') {
        return $this->callApi($path, $params);
    }
    
    public function getValidCurrencies() {
        $valid_currencies_data = $this->callApi('currencies');

        if ($valid_currencies_data === false || !isset($valid_currencies_data['data']) || !is_array($valid_currencies_data['data'])) {
            return false;
        }

        return array_column($valid_currencies_data['data'], 'id');
    }

    public function isValidCurrencySymbol($currency_symbol) { 
        $valid_currencies = $this->getValidCurrencies();
        return in_array($currency_symbol, $valid_currencies);
    }

    public function isValidCurrencySymbolLength($currency_symbol) {
        $symbol_length = strlen($currency_symbol);
        return $symbol_length >= 3 && $symbol_length <= 10;
    }

    public function getCurrencyPrice($currency_symbol) {
        $data = $this->callApi("prices/$currency_symbol-USD/spot");

        if ($data === false || !isset($data['data']['amount'])) {
            return false;
        }

        return $data['data']['amount'];
    }

    public function getCurrencyPairPrice($base_currency, $quote_currency) {
        $data = $this->callApi("prices/$base_currency-$quote_currency/spot");

        if ($data === false || !isset($data['data']['base'], $data['data']['amount'], $data['data']['currency'])) {
            return false;
        }

        return [
            'base' => $data['data']['base'],
            'amount' => $data['data']['amount'],
            'currency' => $data['data']['currency'],
        ];
    }
}