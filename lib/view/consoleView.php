<?php

class ConsoleView {
    private $model;
    
    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function printList(array $allCurrencies): void {
        echo "LIST OF VALID CURRENCIES:" . PHP_EOL;
        foreach ($allCurrencies as $index => $currency_symbol) {
            echo ($index + 1) . ". " . $currency_symbol . PHP_EOL;
        }

    }

        public function printCurrencyPrice(string $currency_symbol, ?array $priceData): void {
            $this->printFormattedCurrencyPrice($currency_symbol, $priceData);
        }
        
        private function printFormattedCurrencyPrice(string $currency_symbol, ?array $priceData): void {
            if ($priceData === false) {
                echo "Unable to retrieve currency data." . PHP_EOL;
                return;
            }
        
            echo sprintf("Price of %s in USD: %s USD" . PHP_EOL, $currency_symbol, $priceData['data']['amount']);
        }
        
        public function printCurrencyPairPrice(string $base_currency, string $quote_currency, ?array $pair_data): void {
            $this->printFormattedCurrencyPairPrice($base_currency, $quote_currency, $pair_data);
        }
        
        private function printFormattedCurrencyPairPrice(string $base_currency, string $quote_currency, ?array $pair_data): void {
            if ($pair_data === false) {
                echo "Unable to retrieve currency pair data." . PHP_EOL;
                return;
            }
        
            echo "$base_currency-$quote_currency Price:" . PHP_EOL;
            echo sprintf("Currency: %s" . PHP_EOL, $pair_data['data']['base']);
            echo sprintf("Price: %s %s" . PHP_EOL, $pair_data['data']['amount'], $pair_data['data']['currency']);
            echo PHP_EOL;
        }

    public function printHelpText() {
        echo <<<TEXT
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
    php console.php_add user <email> <password>
    FOR EXAMPLE: php console.php add_user example@gmail.com password123456
    TEXT . PHP_EOL . PHP_EOL;
    }
}