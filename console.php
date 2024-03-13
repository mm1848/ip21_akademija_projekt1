<?php 

require_once 'lib/view/consoleView.php';
require_once 'lib/model.php';

echo "CRYPTO PRICES" . PHP_EOL . PHP_EOL;

if ($argc < 2 || empty($argv[1])) {
    echo "Provide valid command or try 'help'." . PHP_EOL;
    exit(1);
}

$model = new Model();
$view = new ConsoleView($model);

$command = strtolower($argv[1]);

switch ($command) {
    case 'help':
        $view->printHelpText();
        break;

    case 'list':
        $allCurrencies = $model->getAllCurrencies();
        if ($allCurrencies !== false && isset($allCurrencies['data'])) {
            $currencySymbols = array_column($allCurrencies['data'], 'id');
            $view->printList($currencySymbols);
            askForFavourites($currencySymbols, $model);
        } else {
            echo "Unable to retrieve the list of currencies." . PHP_EOL;
        }
         break;

    case 'single':
        $result = handleSingleCurrencyCommand($model, $view, array_slice($argv, 2));
        echo $result;
        break;
    
    case 'pair':
        $result = handleCurrencyPairCommand($model, $view, array_slice($argv, 2));
        echo $result;
        break;

    case 'favourites':
        $favourites = $model->fetchFavouriteCurrencies(0);
        foreach ($favourites as $favourite) {
            echo $favourite['currency_name'] . PHP_EOL;
        }
        break;

    case 'add_user':
        if ($argc !== 4) {
             echo "Usage: php console.php add_user 'email' 'password'" . PHP_EOL;
             exit(1);
        }
        $email = $argv[2];
        $password = $argv[3];
        addUser($email, $password, $model);
        break;

    default:
        echo "Invalid command. Provide valid command or try 'help'." . PHP_EOL;
        exit(1);
}

function askForFavourites($valid_currency_symbols, $model) {
    echo "Do you wish to mark any as favourite? (y/n): ";
    $response = trim(fgets(STDIN));
    if (strtolower($response) == 'y') {
        echo "Please enter the number(s) in front of the currency you wish to favorite, separated by commas: ";
        $favoriteNumbers = trim(fgets(STDIN));
        $favoriteNumbersArray = explode(',', $favoriteNumbers);
        $favorites = [];
        foreach ($favoriteNumbersArray as $number) {
            $index = (int)$number - 1;
            if (isset($valid_currency_symbols[$index])) {
                $currencyName = $valid_currency_symbols[$index];
                $model->addOrUpdateFavouriteCurrency($currencyName, 0);
                $favorites[] = $currencyName;
            }
        }
        if (!empty($favorites)) {
            echo "You have marked the following as favourite: " . implode(', ', $favorites) . "\n";
        } else {
            echo "No valid currencies selected.\n";
        }
    }
}

function handleSingleCurrencyCommand(Model $model, ConsoleView $view, array $params): ?string {
    if (count($params) !== 1) {
        return "Invalid number of arguments for 'single' command. Provide a valid currency symbol." . PHP_EOL;
    }

    $currency_symbol = strtoupper($params[0]);

    if (!$model->isValidCurrencySymbolLength($currency_symbol)) {
        return "Currency symbols should be between 3 and 10 characters." . PHP_EOL;
    }

    if (!$model->isValidCurrencySymbol($currency_symbol)) {
        return "Invaliad currency symbol '$currency_symbol'. Provide a valid currency symbol or try 'help'." . PHP_EOL;
    }

    $price = $model->getCurrencyPrice($currency_symbol);
    return $view->printCurrencyPrice($currency_symbol, $price, $model);
}

function handleCurrencyPairCommand(Model $model, ConsoleView $view, array $params): ?string {
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

function addUser($email, $password, $model) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $result = $model->addUser($email, $hashedPassword);

    if ($result) {
        echo "User successfully added." . PHP_EOL;
    } else {
        echo "Failed to add user." . PHP_EOL;
    }
}