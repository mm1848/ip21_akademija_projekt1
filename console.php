<?php 

require_once 'lib/view/consoleView.php';
require_once 'lib/model.php';

echo "CRYPTO PRICE VIEWER" . PHP_EOL . PHP_EOL;

if (empty($_SERVER['argv'][1])) {
    echo "Provide valid currency symbols or try 'help'." . PHP_EOL;
    exit(1);
}

$command = strtolower($_SERVER['argv'][1]);

switch ($command) {
    case 'help':
        if (count($_SERVER['argv']) > 2) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        echo printHelpText();
        break;

    case 'list':
        if (count($_SERVER['argv']) > 2) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        $valid_currency_symbols = getValidCurrencies();
        echo printList($valid_currency_symbols);
        break;

    case 'pair':
        handleCurrencyPairCommand();
        break;

    case 'single':
        handleSingleCurrencyCommand();
        break;

    default:
        echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
        exit(1);
}

function handleSingleCurrencyCommand() {
    if (count($_SERVER['argv']) !== 3) {
        echo "Invalid number of arguments for 'single' command. Provide a valid currency symbol." . PHP_EOL;
        exit(1);
    }

    $currency_symbol = strtoupper($_SERVER['argv'][2]);

    if (!isValidCurrencySymbolLength($currency_symbol)) {
        echo "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
        exit(1);
    }

    if (!isValidCurrencySymbol($currency_symbol)) {
        echo "Invalid currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'." . PHP_EOL;
        exit(1);
    }

    $price = getCurrencyPrice($currency_symbol);
    echo printCurrencyPrice($currency_symbol, $price);
}

function handleCurrencyPairCommand() {
    if (count($_SERVER['argv']) !== 4) {
        echo "Invalid number of arguments for 'pair' command. Provide valid base and quote currency symbols." . PHP_EOL;
        exit(1);
    }

    $base_currency = strtoupper($_SERVER['argv'][2]);
    $quote_currency = strtoupper($_SERVER['argv'][3]);

    if (!isValidCurrencySymbolLength($base_currency) || !isValidCurrencySymbolLength($quote_currency)) {
        echo "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
        exit(1);
    }

    if (!isValidCurrencySymbol($base_currency) || !isValidCurrencySymbol($quote_currency)) {
        echo "Invalid currency symbols. Provide valid currency symbols or try 'help'." . PHP_EOL;
        exit(1);
    }

    $pair_data = getCurrencyPairPrice($base_currency, $quote_currency);

    if ($pair_data === false) {
        echo "Unable to retrieve currency pair data." . PHP_EOL;
        exit(1);
    }

    echo printCurrencyPairPrice($base_currency, $quote_currency, $pair_data['base'], $pair_data['amount'], $pair_data['currency']);
}