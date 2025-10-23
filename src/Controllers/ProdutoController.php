<?php
require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/DatabaseController.php';
class ProdutoController {

    public function getProductById(int $id): Produto {
        $connector = new DatabaseController();
        $query = "SELECT * FROM produtos WHERE id = $id";
        $result = $connector->executeQuery($query);
        $productData = $result->fetch_assoc();
        return new Produto($productData);
    }

    public static function getAllProducts(): array {
        $connector = new DatabaseController();
        $query = "SELECT * FROM produtos";
        $result = $connector->executeQuery($query);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = new Produto($row);
        }
        return $products;
    }

}
?>