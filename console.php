<?php 

require_once 'lib/view/consoleView.php';

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

require_once 'lib/model.php';

if (!empty($_SERVER['argv'][1]) && strtolower($_SERVER['argv'][1]) === 'list') {
    echo printList();
    exit();
}

// IZPIS POLJUBNE VALUTE
$currency_symbol = strtoupper($_SERVER['argv'][1]);
if (!in_array($currency_symbol, getValidCurrencies())) {
    echo "Error: Invalid currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'.\n";
    exit(1);
}
echo printCurrencyPrice($currency_symbol);

// IZPIS PARA
if (count($_SERVER['argv']) == 3) {
    $base_currency = strtoupper($_SERVER['argv'][1]);
    $quote_currency = strtoupper($_SERVER['argv'][2]);

    if (!in_array($base_currency, getValidCurrencies()) || !in_array($quote_currency, getValidCurrencies())) {
        echo "Error: Invalid currency symbols. Provide valid currency symbols or try 'help'.\n";
        exit(1);
    }

    echo printCurrencyPairPrice($base_currency, $quote_currency);
} elseif (count($_SERVER['argv']) != 2) {
    echo "Invalid arguments. Provide valid currency symbols or try 'help'.\n";
    exit(1);
}


