# CRYPTO PRICE VIEWER USER STORIES

## USER STORY 1: VIEW LIST OF SUPPORTED CURRENCIES
As a user, I want to see a list of supported currencies,
so that I can know which currencies are supported.

USAGE EXAMPLE:
php console.php list

Expected response: A list of supported currencies.
Confirmed response: Executing php console.php list should display a list of supported currencies.

INCORRECT LIST COMMAND
Description: User provides an incorrect command for listing currencies.
Command: php console.php lst
Expected Response: "Invalid command. Provide valid command or try 'help'."
Confirmed Response: Executing php console.php lst should display the expected error message.

INCORRECT LIST COMMAND WITH EXTRA CHARACTERS
Description: User provides extra characters in the list command.
Command: php console.php list abcdef
Expected Response: "Invalid command. Provide valid command or try 'help'.
Confirmed Response: Executing php console.php list abcdef should display the expected error message.

## USER STORY 2: CHECK SINGLE CURRENCY PRICE
As a user, I want to check the price of a single currency,
so that I can quickly get the current value.

USAGE EXAMPLE:
php console.php single EUR

Expected Response: The current price of the specified single currency in USD.
Confirmed Response: Executing php console.php single EUR should display the current price of Euro (EUR) in USD.

INCORRECT SINGLE CURRENCY COMMAND
Description: User provides an incorrect command for checking a single currency price.
Command: php console.php single DDD
Expected Response: Invalid currency symbol 'DDD'. Provide a valid currency symbol or try 'help'.
Confirmed Response: Executing php console.php single should display the expected error message.

ABSURD USAGE SCENARIOS:
Absurdly Long Currency Symbol
Description: User provides an excessively long currency symbol for a single currency command.
Command: php console.php single SAJHDRFGJASDFRGFASDRUHSDAUGFASDLUGS
Expected Response: "Currency symbols should be between 3 and 10 characters.'
Confirmed Response: Executing php console.php single ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 should display the expected error message.

## USER STORY 3: CHECK CURRENCY PAIR PRICE
As a user, I want to check the price of a currency pair,
so that I can see the exchange rate between two currencies.

USAGE EXAMPLE:
php console.php pair GBP JPY

Expected Response: The current price of the specified currency pair in USD.
Confirmed Response: Executing php console.php pair GBP JPY should display the current price of the British Pound (GBP) to Japanese Yen (JPY) pair in USD.

INCORRECT CURRENCY PAIR COMMAND
Description: User provides an incorrect command for checking a currency pair price.
Command: php console.php pair USD
Expected Response: Invalid currency symbols. Provide valid currency symbols or try 'help'.
Confirmed Response: Executing php console.php pair USD should display the expected error message.

ABSURDLY LONG BASE AND QUOTE CURRENCIES
Description: User provides excessively long base and quote currency symbols for a pair command.
Command: php console.php pair ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890
Expected Response: "Currency symbols should be between 3 and 10 characters".
Confirmed Response: Executing php console.php pair ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 should display the expected error message.

## USER STORY 4: VIEW HELP TEXT
As a user, I want to see help instructions,
so that I can understand how to use the application.

USAGE EXAMPLE:
php console.php help

Expected response: Help instructions on how to use the application.
Confirmed Response: Executing php console.php help should display detailed instructions on how to use the Crypto Price Viewer application.

MISSING HELP COMMAND ARGUMENT
Description: User tries to get help without providing the 'help' argument.
Command: php console.php
Expected response: "Provide valid currency symbols or try 'help'."
Confirmed response: Executing php console.php should display the expected error message.

EXTRA PARAMETER FOR HELP COMMAND
Description: User provides an extra parameter for the help command.
Command: php console.php help extra
Expected Response: "Invalid command. Provide valid command or try 'help'."
Confirmed Response: Executing php console.php help extra should display the expected error message.


