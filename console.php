<?php
// Faza 1: Naloga 1
echo "Hello world\n";
echo "\n";

// Faza 2: Naloga 2
$api_url1 = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
$json_data = file_get_contents($api_url1);
$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading site!\n";
    exit();
}

echo "Currency: " . $data['data']['base'] . "\n";
echo "Price: " . $data['data']['amount'] . " " . $data['data']['currency'] . "\n";
echo "\n";

// Faza 3: Naloga 3
$help_text = "HELP TEXT:
php console.php <currency_symbol>;
currency symbols: EUR,EUR, GBP, JPY, CNY, BTC etc;
EXAMPLE: php console.php ETH\n";

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

    echo "Price of $currency_symbol in USD: " . $data['data']['amount'] . " USD\n";
} else {
    echo $help_text;
}
?>




