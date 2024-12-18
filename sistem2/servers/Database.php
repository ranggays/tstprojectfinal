<?php
class Database {
    private $host = "localhost"; // Host database Anda
    private $db_name = "sistem2_db"; // Nama database Anda
    private $username = "root"; // Username database Anda
    private $password = ""; // Password database Anda
    private $port = "3306"; // Port database Anda
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
