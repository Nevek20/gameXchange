<?php
class Database {
    private static ?PDO $instance = null;

    private function __construct() {}

    private static function loadEnv(): void {
        $path = __DIR__ . '/../.env';
        if (!file_exists($path)) {
            die('Arquivo .env não encontrado.');
        }
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            self::loadEnv();
            try {
                self::$instance = new PDO(
                    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4',
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,
                    ]
                );
            } catch (PDOException $e) {
                error_log('Erro de conexão: ' . $e->getMessage());
                die('Serviço temporariamente indisponível. Tente novamente mais tarde.');
            }
        }
        return self::$instance;
    }
}
