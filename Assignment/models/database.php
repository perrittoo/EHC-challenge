<?php
class Database {
    private $host = "localhost";
    private $db_name = "students";
    private $username = "root";
    private $password = "Vandau2004@";
    public $conn;

    // Kết nối cơ sở dữ liệu
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}


