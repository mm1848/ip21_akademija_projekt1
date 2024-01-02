<?php 

require_once 'lib/view/consoleView.php';
require_once 'lib/model.php';

echo "CRYPTO PRICE VIEWER" . PHP_EOL . PHP_EOL;

if ($argc < 2 || empty($argv[1])) {
    echo "Provide valid command or try 'help'." . PHP_EOL;
    exit(1);
}

$command = strtolower($argv[1]);
$parameters = array_slice($argv, 2);

switch ($command) {
    case 'help':
        if (!empty($parameters)) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        echo printHelpText();
        break;

    case 'list':
        if (!empty($parameters)) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        $valid_currency_symbols = getValidCurrencies();
        echo printList($valid_currency_symbols);
        break;

    case 'single':
        $result = handleSingleCurrencyCommand($parameters);
        echo $result;
        break;
    
    case 'pair':
        $result = handleCurrencyPairCommand($parameters);
        echo $result;
        break;

    default:
        echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
        exit(1);
}

function handleSingleCurrencyCommand($params) {
    if (count($params) !== 1) {
        return "Invalid number of arguments for 'single' command. Provide a valid currency symbol." . PHP_EOL;
    }

    $currency_symbol = strtoupper($params[0]);

    if (!isValidCurrencySymbolLength($currency_symbol)) {
        return "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
    }

    if (!isValidCurrencySymbol($currency_symbol)) {
        return "Invalid currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'." . PHP_EOL;
    }

    $price = getCurrencyPrice($currency_symbol);
    return printCurrencyPrice($currency_symbol, $price);
}

function handleCurrencyPairCommand($params) {
    if (count($params) !== 2) {
        return "Invalid number of arguments for 'pair' command. Provide valid base and quote currency symbols." . PHP_EOL;
       
    }

    $base_currency = strtoupper($params[0]);
    $quote_currency = strtoupper($params[1]);

    if (!isValidCurrencySymbolLength($base_currency) || !isValidCurrencySymbolLength($quote_currency)) {
        return "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
    }

    if (!isValidCurrencySymbol($base_currency) || !isValidCurrencySymbol($quote_currency)) {
        return "Invalid currency symbols. Provide valid currency symbols or try 'help'." . PHP_EOL;
    }

    $pair_data = getCurrencyPairPrice($base_currency, $quote_currency);

    if ($pair_data === false) {
        return "Unable to retrieve currency pair data." . PHP_EOL;
    }

    return printCurrencyPairPrice($base_currency, $quote_currency, $pair_data);
}