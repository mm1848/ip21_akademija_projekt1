<?php 

echo "DOSTOP DO PODATKOV O CENAH CRYPTO INŠTRUMENTOV\n\n";

$help_text = <<<TEXT
HELP TEXT:
1. To check the price of a single currency:
   php console.php <currency_symbol>
   FOR EXAMPLE: php console.php EUR

2. To check the price of any currency pair, provide the symbols of the base and quote currencies:
   php console.php <base_currency> <quote_currency>
   FOR EXAMPLE: php console.php GBP JPY

3. To see all valid currency symbols: php console.php list\n\n 
TEXT;

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'help') {
    echo $help_text;
    exit();
}

if (empty($_SERVER['argv'][1])) {
    echo "Provide valid currency symbols or try 'help'.\n";
    exit(1);
}

// ŠTEVILO ARGUMENTOV
if (count($_SERVER['argv']) == 2) {
    $currency_symbol = strtoupper($_SERVER['argv'][1]);

    // dolžina valute za par
    if (strlen($currency_symbol) < 3 || strlen($currency_symbol) > 10) {
        echo "Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1);
    }
} elseif (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    // dolžina ene valute
    if (strlen($base_currency) < 3 || strlen($base_currency) > 10 || strlen($quote_currency) < 3 || strlen($quote_currency) > 10) {
        echo "Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1);
    }
} else {
    echo $help_text;
    exit();
}

const API_BASE_URL = 'https://api.coinbase.com/v2/';
$validCurrencies = getValidCurrencies(); 

function callApi($path, $params = '') {
    $url = API_BASE_URL . $path . $params;
    $json_data = file_get_contents($url);
    $data = json_decode($json_data, true);

    if ($data === null || !isset($data['data'])) {
        echo "Error loading data!\n";
        exit(1);
    }
    
    return $data;
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

function getValidCurrencies() {
    $valid_currencies_data = callApi('currencies');

    if ($valid_currencies_data === false) {
        echo "Error loading the list of valid currencies. Try again later.\n";
        exit(1);
    }

    $valid_currencies = $valid_currencies_data;
    if (!isset($valid_currencies['data']) || !is_array($valid_currencies['data'])) {
        echo "Error processing the list of valid currencies. Try again later.\n";
        exit(1);
    }

    return array_column($valid_currencies['data'], 'id');
}

function printListOfCurrencies() {
    $valid_currency_symbols = getValidCurrencies();
    $list_of_currencies = "LIST OF VALID CURRENCIES: " . implode(", ", $valid_currency_symbols) . ".\n";
    echo $list_of_currencies;
}

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'list') {
    printListOfCurrencies();
    exit();
}

// IZPIS POLJUBNE VALUTE
$currency_symbol = strtoupper($_SERVER['argv'][1]);
if (!in_array($currency_symbol, getValidCurrencies())) {
    echo "Error: Invalid currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'.\n";
    exit(1);
}
printCurrencyPrice($currency_symbol);

// IZPIS PARA
if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    if (!in_array($base_currency, getValidCurrencies()) || !in_array($quote_currency, getValidCurrencies())) {
        echo "Error: Invalid currency symbols. Provide valid currency symbols or try 'help'.\n";
        exit(1);
    }

    printCurrencyPairPrice($base_currency, $quote_currency);
} elseif (count($_SERVER['argv']) != 2) {
    echo "Invalid arguments. Provide valid currency symbols or try 'help'.\n";
    exit(1);
}


