# Crypto Prices

This project offers two interfaces for checking cryptocurrency prices using the Coinbase API: a simple console application for CLI usage and a web application interface.

## CLI Usage

- To check the price of a single currency:
   ```bash
    php console.php single <currency_symbol>

    To check the price of any currency pair:
  ```bash
    php console.php pair <base_currency> <quote_currency>
    
    To see all valid currency symbols and select favourites:
    ```bash
    php console.php list
    
    To check favourites:
    ```bash
    php console.php favourites
    
    For more information, run:
    ```bash
    php console.php help


# Web Application Setup

Before running the web application, ensure your database is set up correctly:

1. Create a MySQL database named project1.
2. Run the setup_database.sql script to create necessary tables:

  ```bash
  mysql -u yourusername -p project1 < path/to/setup_database.sql


Replace `yourusername` with your MySQL username and adjust the path to the SQL script as necessary.

## Configuration

- Update the database connection settings in `lib/model.php` to match your database credentials.

## Running the Web Application

- To access the web application, navigate to the `public/index.php` file in your web browser, or configure your web server to serve the `public` directory as the root.

## Features

- **CLI**: Check real-time cryptocurrency prices, manage favourites.
- **Web**: User registration and login, display favourite cryptocurrencies, real-time price updates.

## Dependencies

- PHP 7.4 or higher.
- MySQL or MariaDB.
- Composer for managing PHP dependencies.

## Notes

- The CLI part of the application is intended for quick checks and managing favourites.
- The web part allows user-specific customization and displays cryptocurrency prices in a    more interactive manner.

