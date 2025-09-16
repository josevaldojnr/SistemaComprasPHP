<?php 
class Produto {
    public int $id;
    public string $name;
    public float $price;
    public int $stock;

    public function __construct($queryResult=null) {
        if(!is_array($queryResult)) {
            $this->id = 0;
            $this->name = '';
            $this->price = 0.0;
            $this->stock = 0;
            return;
        }
        $this->id = $queryResult['id'];
        $this->name = $queryResult['name'];
        $this->price = $queryResult['price'];
        $this->stock = $queryResult['stock'];
      
    }

    public function isInStock(): bool {
        return $this->stock > 0;
    }

    public function reduceStock(int $amount): void {
        if ($this->isInStock() === false ) {
            throw new Exception("Fora de Estoque");
        }
        $this->stock -= $amount;
    }

    public function increaseStock(int $amount): void {
        $this->stock += $amount;
    }

}

?>