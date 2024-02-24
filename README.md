# Crypto Prices

This is a simple console application to check cryptocurrency prices using the Coinbase API.

## Usage

- To check the price of a single currency:
  ```bash
  php console.php single <currency_symbol>

- To check the price of any currency pair: 
  ```bash
  php console.php pair <base_currency> <quote_currency>

- To see all valid currency symbols and select favourites:
    ```bash
    php console.php list

- To check favourites: 
  ```bash
  php console.php favourites

- For more information, run:
    ```bash
    php console.php help