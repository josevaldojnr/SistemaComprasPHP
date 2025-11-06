<?php
require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/DatabaseController.php';

class ProdutoController {
    private $dbController;

    public function __construct() {
        $this->dbController = new DatabaseController();
    }

    public function getProductById(int $id): Produto {
        $conn = $this->dbController->getConnection();
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Produto($productData);
    }

    public function getAllProducts(): array {
        $conn = $this->dbController->getConnection();
        $query = "SELECT * FROM produtos";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
     
        foreach($result as $row) {
            $products[] = new Produto($row);
        }
         return $products;
    }
}
?>