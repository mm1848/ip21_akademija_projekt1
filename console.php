<?php 

require_once 'lib/view/consoleView.php';
require_once 'lib/model.php';

echo "CRYPTO PRICE VIEWER" . PHP_EOL . PHP_EOL;

if ($argc < 2 || empty($argv[1])) {
    echo "Provide valid command or try 'help'." . PHP_EOL;
    exit(1);
}

$model = new Model();
$view = new ConsoleView($model);

$command = strtolower($argv[1]);
$parameters = array_slice($argv, 2);

switch ($command) {
    case 'help':
        if (!empty($parameters)) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        $view->printHelpText();
        break;

    case 'list':
        if (!empty($parameters)) {
            echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
            exit(1);
        }
        $valid_currency_symbols = $model->getValidCurrencies();
        $view->printList($valid_currency_symbols);
        break;

    case 'single':
            $result = handleSingleCurrencyCommand($model, $view, $parameters);
            echo $result;
            break;
        
    case 'pair':
            $result = handleCurrencyPairCommand($model, $view, $parameters);
            echo $result;
            break;

    default:
        echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
        exit(1);
}

function handleSingleCurrencyCommand(Model $model, ConsoleView $view, $params) {
    if (count($params) !== 1) {
        return "Invalid number of arguments for 'single' command. Provide a valid currency symbol." . PHP_EOL;
    }

    $currency_symbol = strtoupper($params[0]);

    if (!$model->isValidCurrencySymbolLength($currency_symbol)) {
        return "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
    }

    if (!$model->isValidCurrencySymbol($currency_symbol)) {
        return "Invalid currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'." . PHP_EOL;
    }

    $price = $model->getCurrencyPrice($currency_symbol);
    return $view->printCurrencyPrice($currency_symbol, $price, $model);
}

function handleCurrencyPairCommand(Model $model, ConsoleView $view, $params) {
    if (count($params) !== 2) {
        return "Invalid number of arguments for 'pair' command. Provide valid base and quote currency symbols." . PHP_EOL;
       
    }

    $base_currency = strtoupper($params[0]);
    $quote_currency = strtoupper($params[1]);

    if (!$model->isValidCurrencySymbolLength($base_currency) || !$model->isValidCurrencySymbolLength($quote_currency)) {
        return "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
    }

    if (!$model->isValidCurrencySymbol($base_currency) || !$model->isValidCurrencySymbol($quote_currency)) {
        return "Invalid currency symbols. Provide valid currency symbols or try 'help'." . PHP_EOL;
    }

    $pair_data = $model->getCurrencyPairPrice($base_currency, $quote_currency);

    if ($pair_data === false) {
        return "Unable to retrieve currency pair data." . PHP_EOL;
    }

    return $view->printCurrencyPairPrice($base_currency, $quote_currency, $pair_data, $model);
}