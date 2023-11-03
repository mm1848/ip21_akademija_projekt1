<?php 
error_reporting(0);

// Faza 1: Naloga 1 
echo "Hello world\n";
echo "\n";

// Naloga 2: Izpis podatka o BTC
$api_url1 = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
$json_data = file_get_contents($api_url1);
$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading site!\n";
    exit();
}

echo sprintf("Currency: %s\n", $data['data']['base']);
echo sprintf("Price: %s %s\n", $data['data']['amount'], $data['data']['currency']);
echo "\n";

//Naloga 3: Izpis poljubne valute proti USD
$help_text = <<<TEXT
HELP TEXT:
- To check the price of a single currency:
  php console.php <currency_symbol>
  Currency symbols: EUR, GBP, JPY, CNY, BTC, ETH, etc.
  FOR EXAMPLE: php console.php ETH

- To check the price of any currency pair, provide the symbols of the base and quote currencies:
  php console.php <base_currency> <quote_currency>
  Currency symbols: EUR, GBP, JPY, CNY, BTC, ETH, etc.
  FOR EXAMPLE: php console.php GBP JPY
TEXT;

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'help') {
    echo $help_text;
    exit();
}

if (!empty($_SERVER['argv'][1])) {
    $currency_symbol = strtoupper($_SERVER['argv'][1]);

    $api_url2 = "https://api.coinbase.com/v2/prices/$currency_symbol-USD/spot";
    $json_data = file_get_contents($api_url2);
    $data = json_decode($json_data, true);

    if ($data === null || !isset($data['data'])) {
        echo "Error loading data for $currency_symbol!\n";
        exit();
    }
  echo sprintf("Price of %s in USD: %s USD\n", $currency_symbol, $data['data']['amount']);
} else {
    echo $help_text;
}


// Naloga 3: Izpis za poljubni par:
// 
if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    $api_url3 = "https://api.coinbase.com/v2/prices/$base_currency-$quote_currency/spot";
} else if (count($_SERVER['argv']) == 2) {
    echo "Provide both the base and quote currency symbols.\n";
    echo $help_text;
    exit(1); 
} else {
    echo "Invalid arguments. Provide valid currency symbols or use 'help' for usage.\n";
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



// Naloga 4: Odpornost na napačne argumente
if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    // dolžina valute
    if (strlen($base_currency) < 3 || strlen($base_currency) > 10 || strlen($quote_currency) < 3 || strlen($quote_currency) > 10) {
        echo "Invalid currency symbols. Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1); 
    }

    $api_url4 = "https://api.coinbase.com/v2/prices/$base_currency-$quote_currency/spot";
} elseif (count($_SERVER['argv']) == 2) {
    $currency_symbol = strtoupper($_SERVER['argv'][1]);

    if (strlen($currency_symbol) < 3 || strlen($currency_symbol) > 10) {
        echo "Invalid currency symbol. Currency symbols should be between 3 and 10 characters.\n";
        echo $help_text;
        exit(1);
    }

    $api_url4 = "https://api.coinbase.com/v2/prices/$currency_symbol-USD/spot";
} else {
    echo $help_text;
    exit();
}


if ($json_data === false) {
    echo "Error loading data for $base_currency-$quote_currency. Please check if the currency pair exists and try again.\n";
    exit(1); 
}

$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading data for $base_currency-$quote_currency. Please check if the currency pair exists and try again.\n";
    echo $help_text;
    exit(1); 
}

echo "$base_currency-$quote_currency Price:\n";
echo sprintf("Currency: %s\n", $data['data']['base']);
echo sprintf("Price: %s %s\n", $data['data']['amount'], $data['data']['currency']);
















