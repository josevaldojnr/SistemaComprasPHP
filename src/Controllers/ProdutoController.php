<?php
require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/DatabaseController.php';
class ProdutoController {

    public function getProductById(int $id): Produto {
        $connector = new DatabaseController();
        $query = "SELECT * FROM products WHERE id = $id";
        $result = $this->connector->executeQuery($query);
        $productData = $result->fetch_assoc();
        return new Produto($productData);
    }

    public function getAllProducts(): array {
        $query = "SELECT * FROM products";
        $result = $this->connector->executeQuery($query);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Produto($row);
        }
        return $products;
    }

}
?>