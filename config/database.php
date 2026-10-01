<?php 

class Database {

    private static ?PDO $instance = null;

    private string $host = 'localhost';
    private string $dbName = 'alzikrayat_db';
    private string $username = 'root';
    private string $password = '';
    private string $charset = 'utf8mb4';

    /** 
     * @return PDO
     */
    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dbConfig = new self();
            self::$instance = $dbConfig->connect();
        }
        return self::$instance;
    }

    private function connect(): PDO {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            return new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}