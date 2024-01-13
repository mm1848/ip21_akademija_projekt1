<?php

class Model {
    const API_BASE_URL = 'https://api.coinbase.com/v2/';
    private $listOfCurrencies = null;

    private function callApi($path, $params = '') {
        $url = self::API_BASE_URL . $path . $params;
        $json_data = file_get_contents($url);
        $data = json_decode($json_data, true);

        return ($data !== null && isset($data['data'])) ? $data : false;
    }

    private function getList() {
        if ($this->listOfCurrencies !== null) {
            return $this->listOfCurrencies;
        }

        $data = $this->callApi('currencies');

        if ($data === false) {
            return false;
        }

        $this->listOfCurrencies = $data['data'];
        return $this->listOfCurrencies;
    }

    public function areTheEnteredTagsOnList($currency) {
        $list = $this->getList();

        if ($list === false || !is_array($list)) {
            return false;
        }

        return in_array($currency, array_column($list, 'id'));
    }

    public function getValidCurrencies() {
        return $this->callApi('currencies');
    }

    public function isValidCurrencySymbol($currency_symbol) {
        $valid_currencies = $this->getValidCurrencies();

        if ($valid_currencies === false || !isset($valid_currencies['data']) || !is_array($valid_currencies['data'])) {
            return false;
        }

        return in_array($currency_symbol, array_column($valid_currencies['data'], 'id'));
    }

    public function isValidCurrencySymbolLength($currency_symbol) {
        $symbol_length = strlen($currency_symbol);
        return $symbol_length >= 3 && $symbol_length <= 10;
    }

    public function getCurrencyPrice($currency_symbol) {
        return $this->callApi("prices/$currency_symbol-USD/spot");
    }

    public function getCurrencyPairPrice($base_currency, $quote_currency) {
        return $this->callApi("prices/$base_currency-$quote_currency/spot");
    }
}
