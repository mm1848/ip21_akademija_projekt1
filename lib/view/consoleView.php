<?php

function printList(){
$valid_currency_symbols = getValidCurrencies();
    $list_of_currencies = "LIST OF VALID CURRENCIES: " . implode(", ", $valid_currency_symbols) . ".\n";
    echo $list_of_currencies;
}

function printCurrencyPrice($currency_symbol) {
    $data = callApi("prices/$currency_symbol-USD/spot");
    echo sprintf("Price of %s in USD: %s USD\n", $currency_symbol, $data['data']['amount']);
}

function printCurrencyPairPrice($base_currency, $quote_currency) {
    $data = callApi("prices/$base_currency-$quote_currency/spot");
    echo "$base_currency-$quote_currency Price:\n";
    echo sprintf("Currency: %s\n", $data['data']['base']);
    echo sprintf("Price: %s %s\n", $data['data']['amount'], $data['data']['currency']);
    echo "\n";
}

function printHelpText()
{
    echo <<<TEXT
HELP TEXT:
1. To check the price of a single currency:
   php console.php <currency_symbol>
   FOR EXAMPLE: php console.php EUR

2. To check the price of any currency pair, provide the symbols of the base and quote currencies:
   php console.php <base_currency> <quote_currency>
   FOR EXAMPLE: php console.php GBP JPY

3. To see all valid currency symbols: php console.php list\n\n 
TEXT;
}