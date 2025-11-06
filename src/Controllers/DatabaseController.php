<?php
class DatabaseController {
    private $host = '127.0.0.1';
    private $port = '3306';
    private $username = 'root';
    private $password = '';
    private $dbname = 'sistema_compras';
    public $conn;

    public function __construct() {
        $this->getConnection();
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>
