<?php
class DatabaseController {
    private $dbConnection;
    private $host = '0.0.0.0:3306';
    private $username='root';
    private $password='minhasenha123';
    private $dbname='sistema_compras';

    public function __construct() {
        $this->dbConnection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->dbConnection->connect_error) {
            throw new Exception("Connection failed: " . $this->dbConnection->connect_error);
        }
    }

    public function getConnection() {
        return $this->dbConnection;
    }

    public function closeConnection() {
        $this->dbConnection->close();
    }

    public function executeQuery($query) {
        $result = $this->dbConnection->query($query);
        if ($this->dbConnection->error) {
            throw new Exception("Error: " . $this->dbConnection->error);
        }
        if($result->num_rows === 0) {
           throw new Exception("No Results Found");
        }
        return $result;
    }
}
?>
