<?php 
echo "DOSTOP DO PODATKOV O CENAH CRYPTO INŠTRUMENTOV\n\n";

$help_text = <<<TEXT
HELP TEXT:
1. To check the price of a single currency:
  php console.php <currency_symbol>
  Currency symbols: EUR, GBP, JPY, CNY, BTC, ETH, etc.
  FOR EXAMPLE: php console.php ETH.

2. To check the price of any currency pair, provide the symbols of the base and quote currencies:
  php console.php <base_currency> <quote_currency>
  Currency symbols: EUR, GBP, JPY, CNY, BTC, ETH, etc.
  FOR EXAMPLE: php console.php GBP JPY.

3. Commands: 'help', 'list'.\n\n
TEXT;

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'help') {
    echo $help_text;
    exit();
}

if (empty($_SERVER['argv'][1])) {
    echo "Invalid arguments. Provide valid currency symbols or try 'help'.\n";
    exit(1);
}

$list_of_currencies = <<<TEXT
LIST OF VALID CURRENCIES:
"AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AUD", "AWG", "AZN", "BAM", "BBD", "BDT", "BGN", "BHD", "BIF", "BMD", "BND", "BOB", "BRL", "BSD", "BTN", "BWP", "BYN", 
"BYR", "BZD", "CAD", "CDF", "CHF", "CLF", "CLP", "CNY", "COP", "CRC", "CUC", "CUP", "CVE", "CZK", "DJF", "DKK", "DOP", "DZD", "EGP", "ETB", "EUR", "FJD", "FKP", "GBP", 
"GEL", "GHS", "GIP", "GMD", "GNF", "GTQ", "GYD", "HKD", "HNL", "HRK", "HTG", "HUF", "IDR", "ILS", "IMP", "INR", "IQD", "IRR", "ISK", "JEP", "JMD", "JOD", "JPY", "KES", 
"KGS", "KHR", "KMF", "KRW", "KWD", "KYD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL", "LTL", "LVL", "LYD", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MRU", "MUR", 
"MVR", "MWK", "MXN", "MYR", "MZN", "NAD", "NGN", "NIO", "NOK", "NPR", "NZD", "OMR", "PAB", "PEN", "PGK", "PHP", "PKR", "PLN", "PYG", "QAR", "RON", "RSD", "RUB", "RWF", 
"SAR", "SBD", "SCR", "SDG", "SEK", "SGD", "SHP", "SLL", "SOS", "SRD", "STD", "SVC", "SZL", "THB", "TJS", "TMM", "TMT", "TND", "TOP", "TRY", "TTD", "TWD", "TZS", "UAH", 
"UGX", "USD", "UYU", "UZS", "VEF", "VES", "VND", "VUV", "WST", "XAF", "XAG", "XAU", "XCD", "XDR", "XOF", "XPD", "XPF", "XPT", "YER", "ZAR", "ZMK", "ZMW", "ZWD", "CNH".\n 
TEXT;

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'list') {
    echo $list_of_currencies;
    exit();
}

// IZPIS PODATKA O BTC
$api_url1 = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
$json_data = file_get_contents($api_url1);
$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading site!\n";
    exit(1);
}

if ($json_data === false) {
    echo "Error loading data for $base_currency-$quote_currency. Check if the currency pair exists and try again.\n";
    exit(1); 
}

//IZPIS POLJUBNE VALUTE PROTU USD
if (!empty($_SERVER['argv'][1])) {
    $currency_symbol = strtoupper($_SERVER['argv'][1]);

    $api_url2 = "https://api.coinbase.com/v2/prices/$currency_symbol-USD/spot";
    $json_data = file_get_contents($api_url2);
    $data = json_decode($json_data, true);

    if ($data === null || !isset($data['data'])) {
        echo "Error loading data for $currency_symbol!\n\n";
        echo $help_text;
        exit();
    }
  echo sprintf("Price of %s in USD: %s USD\n", $currency_symbol, $data['data']['amount']);
} else {
    echo $help_text;
}

// IZPIS ZA POLJUBNI PAR
if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);
    $api_url3 = "https://api.coinbase.com/v2/prices/$base_currency-$quote_currency/spot";
} else if (count($_SERVER['argv']) == 2) {
    echo "Provide both the base and quote currency symbols.\n\n";
    echo $help_text;
    exit(1); 
} else {
    echo "Invalid arguments. Provide valid currency symbols or try 'php console.php help'.\n";
    exit(1); 
}

$json_data = file_get_contents($api_url3);
$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading data for $base_currency-$quote_currency. Check if the currency pair exists and try again.\n";
    echo $help_text;
    exit(1); 
}

echo "$base_currency-$quote_currency Price:\n";
echo sprintf("Currency: %s\n", $data['data']['base']);
echo sprintf("Price: %s %s\n", $data['data']['amount'], $data['data']['currency']);
echo "\n";

// ŠTEVILO ARGUMENTOV
if (count($_SERVER['argv']) == 2) {
    $currency_symbol = strtoupper($_SERVER['argv'][1]);

    // DOLŽINA VALUTE ZA PAR
    if (strlen($currency_symbol) < 3 || strlen($currency_symbol) > 10) {
        echo "Invalid currency symbol. Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1);
    }
} elseif (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    // DOLŽINA ENE VALUTE
    if (strlen($base_currency) < 3 || strlen($base_currency) > 10 || strlen($quote_currency) < 3 || strlen($quote_currency) > 10) {
        echo "Invalid currency symbols. Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1);
    }
} else {
    echo $help_text;
    exit();
}

//VALID VALUTE
$valid_currencies_data_url4 = 'https://api.coinbase.com/v2/currencies';
$valid_currencies_data = file_get_contents($valid_currencies_data_url4);

if ($valid_currencies_data === false) {
    echo "Error loading the list of valid currencies. Try again later.\n";
    exit(1);
}

$valid_currencies = json_decode($valid_currencies_data, true);
if ($valid_currencies === null || !isset($valid_currencies['data']) || !is_array($valid_currencies['data'])) {
    echo "Error processing the list of valid currencies. Try again later.\n";
    exit(1);
}

$valid_currency_symbols = array_column($valid_currencies['data'], 'id');

if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    $is_base_valid = in_array($base_currency, $valid_currency_symbols);
    $is_quote_valid = in_array($quote_currency, $valid_currency_symbols);
    
    if (!$is_base_valid && !$is_quote_valid) {
        echo "Invalid currency symbols. Both base and quote currencies should be valid.\n";
        exit(1);
    }
}










