<?php 
class Produto {
    private int $id;
    private string $name;
    private float $price;

    public function __construct(array $data) {
        $this->id = $data['id'] ?? 0; 
        $this->name = $data['nome'] ?? ''; 
        $this->price = $data['preco'] ?? 0.0; 
    }
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPrice(): float {
        return $this->price;
    }
}
?>