# Crypto Prices

Crypto Prices is a project that allows users to view real-time cryptocurrency prices via the Coinbase API. The project offers two interfaces: a simple console application for command-line (CLI) usage and a web interface for a more interactive experience.

## CLI Usage

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

## Features

- **CLI**: Check real-time cryptocurrency prices, manage favourites.
- **Web**: User registration and login, display favourite cryptocurrencies, real-time price updates.

## Requirements

- PHP 7.4 or higher.
- MySQL or MariaDB.
- Composer for managing PHP dependencies.

## Installation

To install the Crypto Prices application, follow these steps:

1. Clone the repository to your local machine:
   ```bash
   git clone <url-to-your-repository>

2. Install PHP dependencies by running Composer in the project's root directory:
   ``bash
   composer install

3. Database setup:
- Create a MySQL database named project1.
- Run the setup_database.sql script to create the necessary tables. Ensure you replace yourusername with your actual MySQL username and adjust the path to the setup_database.sql script as necessary:
    ```bash
      mysql -u yourusername -p project1 < path/to/setup_database.sql
- Update the database connection settings in `lib/model.php` to match your database credentials.

## Running the Web Application
  - To access the web application, navigate to the public/index.php file in your web browser or configure your web server to serve the public directory as the root.

## Notes

- The CLI part of the application is intended for quick checks and managing favourites.
- The web part allows user-specific customization and displays cryptocurrency prices in a more interactive manner.