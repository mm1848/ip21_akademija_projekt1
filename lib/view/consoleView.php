<?php

class ConsoleView {
    private $model;
    
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function printList($valid_currency_symbols) {
        if (is_array($valid_currency_symbols)) {
            if (!empty($valid_currency_symbols)) {
                $list_of_currencies = "LIST OF VALID CURRENCIES: " . implode(", ", $valid_currency_symbols) . PHP_EOL;
                echo $list_of_currencies;
            } else {
                echo "Error: Valid currency symbols list is empty." . PHP_EOL;
            }
        } else {
            echo "Error: Unable to retrieve valid currency symbols." . PHP_EOL;
        }
    }

    public function printCurrencyPrice($currency_symbol) {
        $data = $this->model->getCurrencyPrice($currency_symbol);
        echo sprintf("Price of %s in USD: %s USD" . PHP_EOL, $currency_symbol, $data['data']['amount']);
    }

    public function printCurrencyPairPrice($base_currency, $quote_currency) {
        $data = $this->model->getCurrencyPairPrice($base_currency, $quote_currency);
        echo "$base_currency-$quote_currency Price:" . PHP_EOL;
        echo sprintf("Currency: %s" . PHP_EOL, $data['data']['base']);
        echo sprintf("Price: %s %s" . PHP_EOL, $data['data']['amount'], $data['data']['currency']);
        echo PHP_EOL;
    }

    public function printHelpText() {
        echo <<<TEXT
    HELP TEXT:
    1. To check the price of a single currency:
    php console.php single <currency_symbol>
    FOR EXAMPLE: php console.php single EUR

    2. To check the price of any currency pair, provide the symbols of the base and quote currencies:
    php console.php pair <base_currency> <quote_currency>
    FOR EXAMPLE: php console.php pair GBP JPY

    3. To see all valid currency symbols: php console.php list
    TEXT . PHP_EOL . PHP_EOL;
    }

}