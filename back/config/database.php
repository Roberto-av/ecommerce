<?php
class Database
{
    private $host = "localhost";
    private $db_name = "ecommerce_v1";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection(): PDO
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage()); 
        }
        return $this->conn;
    }

    public function createTable($tableName)
    {
        if ($this->conn) {
            try {
                $sql = "CREATE TABLE IF NOT EXISTS $tableName (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(255) NOT NULL,
                        description TEXT,
                        category VARCHAR(100),
                        price DECIMAL(10, 2) NOT NULL,
                        discountPercentage DECIMAL(5, 2),
                        rating DECIMAL(3, 2),
                        stock INT,
                        tags JSON,
                        brand VARCHAR(100),
                        image VARCHAR(255),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )";
                $this->conn->exec($sql);
            } catch (PDOException $exception) {
                error_log("Table creation error: " . $exception->getMessage());
            }
        } else {
            error_log("No database connection. Cannot create table.");
        }
    }
}
