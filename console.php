<?php

//Faza 1: Naloga 1
echo "Hello world";
echo "<br />";
echo "<br />";

//Faza 2: Naloga 2
$api_url = 'https://api.coinbase.com/v2/prices/BTC-USD/spot';
$json_data = file_get_contents($api_url);
$data = json_decode($json_data, true);

if ($data === null || !isset($data['data'])) {
    echo "Error loading site!";
    exit();
}

echo "Currency: " . $data['data']['base'] . "\n";
echo "<br />";
echo "Price: " . $data['data']['amount'] . " " . $data['data']['currency'] . "\n";


?>