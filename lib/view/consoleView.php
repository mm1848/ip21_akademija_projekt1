<?php

function printList(){
    $valid_currency_symbols = getValidCurrencies();
    $list_of_currencies = "LIST OF VALID CURRENCIES: " . implode(", ", $valid_currency_symbols) . PHP_EOL;
    echo $list_of_currencies;
}

function printCurrencyPrice($currency_symbol) {
    $data = callApi("prices/$currency_symbol-USD/spot");
    echo sprintf("Price of %s in USD: %s USD" . PHP_EOL, $currency_symbol, $data['data']['amount']);
}

function printCurrencyPairPrice($base_currency, $quote_currency) {
    $data = callApi("prices/$base_currency-$quote_currency/spot");
    echo "$base_currency-$quote_currency Price:" . PHP_EOL;
    echo sprintf("Currency: %s" . PHP_EOL, $data['data']['base']);
    echo sprintf("Price: %s %s" . PHP_EOL, $data['data']['amount'], $data['data']['currency']);
    echo PHP_EOL;
}

function printHelpText() {
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