<?php

class Model {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=project1;charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new PDO($dsn, 'project1_www', 'kbOx_lA9X*C_LN6Y', $options);
        } catch (PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
}
    const API_BASE_URL = 'https://api.coinbase.com/v2/';
    private $listOfCurrencies = null;

    private function callApi(string $path, string $params = ''): ?array {
        $url = self::API_BASE_URL . $path . $params;
        $json_data = file_get_contents($url);
        $data = json_decode($json_data, true);

        return ($data !== null && isset($data['data'])) ? $data : false;
    }

    public function getValidCurrencies(): ?array {
        return $this->callApi('currencies');
    }
    
    public function getCryptocurrencies(): ?array {
        return $this->callApi('currencies/crypto');
    }
    
    public function getAllCurrencies(): ?array {
        $fiatCurrencies = $this->getValidCurrencies();
        $cryptoCurrencies = $this->getCryptocurrencies();
        if (!$fiatCurrencies || !$cryptoCurrencies) {
            return null;
        }
        
        $cryptoCurrenciesAdjusted = array_map(function($currency) {
            if (isset($currency['code']) && !isset($currency['id'])) {
                $currency['id'] = $currency['code'];
            }
            return $currency;
        }, $cryptoCurrencies['data']);
        
        $allCurrencies = array_merge($fiatCurrencies['data'], $cryptoCurrenciesAdjusted);
        return ['data' => $allCurrencies];
    }

    private function getList(): ?array {
        if ($this->listOfCurrencies !== null) {
            return $this->listOfCurrencies;
        }

        $data = $this->callApi('currencies');

        if ($data === false) {
            return false;
        }

        $this->listOfCurrencies = $data['data'];
        return $this->listOfCurrencies;
    }

    public function areTheEnteredTagsOnList(string $currency): bool {
        $list = $this->getList();

        if ($list === false || !is_array($list)) {
            return false;
        }

        return in_array($currency, array_column($list, 'id'));
    }

    public function isValidCurrencySymbol(string $currency_symbol): bool {
        $allCurrencies = $this->getAllCurrencies();

        if ($allCurrencies === false || !isset($allCurrencies['data']) || !is_array($allCurrencies['data'])) {
            return false;
        }

        return in_array($currency_symbol, array_column($allCurrencies['data'], 'id'));
    }
    public function isValidCurrencySymbolLength(string $currency_symbol): bool {
        $symbol_length = strlen($currency_symbol);
        return $symbol_length >= 3 && $symbol_length <= 10;
    }

    public function getCurrencyPrice(string $currency_symbol): ?array {
        return $this->callApi("prices/$currency_symbol-USD/spot");
    }

    public function getCurrencyPairPrice(string $base_currency, string $quote_currency): ?array {
        return $this->callApi("prices/$base_currency-$quote_currency/spot");
    }

    public function addOrUpdateFavouriteCurrency(string $currencyName, int $user_id): void {
        if ($this->isCurrencyFavourite($currencyName, $user_id)) {
            return;
        }
        $sql = "INSERT INTO favourites (user_id, currency_name) VALUES (:user_id, :currency_name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'currency_name' => $currencyName]);
    }
    
    public function fetchFavouriteCurrencies(int $user_id): array {
        $sql = "SELECT currency_name FROM favourites WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function removeFavouriteCurrency(string $currencyName, int $user_id): void {
        $sql = "DELETE FROM favourites WHERE user_id = :user_id AND currency_name = :currency_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'currency_name' => $currencyName]);
    }
    
    public function isCurrencyFavourite(string $currencyName, int $user_id): bool {
        $sql = "SELECT 1 FROM favourites WHERE user_id = :user_id AND currency_name = :currency_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'currency_name' => $currencyName]);
        return $stmt->fetch() ? true : false;
    }
    
    public function addUser(string $email, string $hashedPassword): bool {
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$email, $hashedPassword]);
    }
    
    public function checkUserCredentials(string $email, string $password): ?array {
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function userExists(string $email): bool {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}