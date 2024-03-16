<?php

class ConsoleView {
    private $model;
    private $climate;

    public function __construct(Model $model, $climate) {
        $this->model = $model;
        $this->climate = $climate;
    }

    public function printList(array $allCurrencies, $climate) {
        $climate->bold()->out("LIST OF CURRENCIES:")->br();
        $columns = 10;
        $currencyCount = count($allCurrencies);
        $rows = ceil($currencyCount / $columns);
    
        for ($row = 0; $row < $rows; $row++) {
            $line = '';
            for ($col = 0; $col < $columns; $col++) {
                $index = $row + ($col * $rows);
                if ($index < $currencyCount) {
                    $line .= sprintf("%-15s", ($index + 1) . ". " . $allCurrencies[$index]);
                }
            }
            $climate->out($line);
        }
        $climate->br();
    }
    
    public function printCurrencyPrice(string $currency_symbol, ?array $priceData, $climate): void {
        $this->printFormattedCurrencyPrice($currency_symbol, $priceData, $climate);
    }
        
    private function printFormattedCurrencyPrice(string $currency_symbol, ?array $priceData, $climate): void {
        if ($priceData === false) {
            $climate->red()->bold()->out("Unable to retrieve currency data." . PHP_EOL);
        return;
        }
        $this->climate->out(sprintf("Price of %s in USD: %s USD", $currency_symbol, $priceData['data']['amount']));

        }
        
    public function printCurrencyPairPrice(string $base_currency, string $quote_currency, ?array $pair_data, $climate): void {
        $this->printFormattedCurrencyPairPrice($base_currency, $quote_currency, $pair_data, $climate);
        }
        
    private function printFormattedCurrencyPairPrice(string $base_currency, string $quote_currency, ?array $pair_data, $climate): void {
        if ($pair_data === false) {
            $climate->red()->bold()->out("Unable to retrieve currency pair data." . PHP_EOL);
            return;
        }
        
        echo "$base_currency-$quote_currency Price:" . PHP_EOL;
        echo sprintf("Currency: %s" . PHP_EOL, $pair_data['data']['base']);
        echo sprintf("Price: %s %s" . PHP_EOL, $pair_data['data']['amount'], $pair_data['data']['currency']);
        echo PHP_EOL;
        }

    public function printHelpText($climate) {
            $helpText = <<<TEXT
        HELP TEXT:
        1. To check the price of a single currency:
           php console.php single <currency_symbol>
           FOR EXAMPLE: php console.php single EUR
        
        2. To check the price of any currency pair, provide the symbols of the base and quote currencies:
           php console.php pair <base_currency> <quote_currency>
           FOR EXAMPLE: php console.php pair GBP JPY
        
        3. To see all valid currency symbols: php console.php list
        
        4. To manage favorites: php console.php favorites
        
        5. To add a new user with email and password:
           php console.php add_user <email> <password>
           FOR EXAMPLE: php console.php add_user example@gmail.com password123456
        TEXT;
            $climate->bold()->out($helpText);
    }
}