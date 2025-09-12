<?php
class DatabaseController {
    private $dbConnection;

    public function __construct($host, $username, $password, $dbname) {
        $this->dbConnection = new mysqli($host, $username, $password, $dbname);
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
