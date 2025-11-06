<?php
    //STATUS
    //1 = requisitado
    //2 = precificado
    //3 = pedido gerado
    //4 = aprovado
    //5 = rejeitado
    //6 = cancelado
    //7 = finalizado 

require_once __DIR__ . '/User.php';
    class Requisicao{
        public int $id;
        public int $requestor_id;
        public int $pricing_id;
        public int $buyer_id;
        public int $manager_id;
        public int $total_cost;
        public int $status_id;

         public function __construct($queryResult=null, User $user=null) {
            if(!is_array($queryResult)) {
                $this->id = 0 ;
                $this->requestor_id = $user->id;
                $this->pricing_id = 0;
                $this->purchasing_id = 0;
                $this->manager_id = 0;
                $this->total_cost = 0;
                $this->status_id = 0;
                $this->requestor_name = '';
                $this->status_name = '';
                return;
            }
            $this->id = $queryResult['id'];
            $this->requestor_id = $queryResult['requestor_id'];
            $this->pricing_id = $queryResult['pricing_id'] ?? 0;
            $this->purchasing_id = $queryResult['purchasing_id']?? 0;
            $this->manager_id = $queryResult['manager_id']?? 0;
            $this->total_cost = $queryResult['total_cost'];
            $this->status_id = $queryResult['status_id'];
            $this->status_name = $queryResult['status_name'];
            $this->requestor_name = $queryResult['requestor_name'];
    }

    public static function getAll():array{
        $db = new DatabaseController();
        $connection=$db->getConnection();
        $result=$connection->query("SELECT 
                                        r.id, 
                                        r.requestor_id, 
                                        u.name as requestor_name,
                                        r.total_cost, 
                                        r.status_id,
                                        CASE r.status_id
                                            WHEN 1 THEN 'Requisitado'
                                            WHEN 2 THEN 'Precificado'
                                            WHEN 3 THEN 'Pedido Gerado'
                                            WHEN 4 THEN 'Aprovado'
                                            WHEN 5 THEN 'Recusado'
                                            WHEN 6 THEN 'Cancelado'
                                            WHEN 7 THEN 'Finalizado'
                                            ELSE 'Desconhecido'
                                        END as status_name
                                    FROM requisicao r 
                                    JOIN users u ON r.requestor_id = u.id");

        $requests=[];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) { // Fetch one row at a time
            $requests[] = new Requisicao($row); // Pass the single row to the constructor
        }
        $connection = null; // Close connection
        return $requests;
    }

    public function getAllbyUser(int $user_id):array{

    }

    public function getAllbyStatus(int $status_id):array{

    }

    public function isRequested(): bool {
        if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 1;
    }

    public function isPriced():bool{
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 2;
    }

    public function isOrdered():bool{
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 3;
    }

    public function isApproved():bool{
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 4;
    }

    public function isRejected():bool{
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 5;
    }

    public function isCanceled():bool{
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 6;
    }

    public function isFinished(){
         if($this->status_id>7 || $this->status_id<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status_id === 7;
    }

    public function createRequisicao($data, $produtos)
{
    $db = new DatabaseController();
    $connection = $db->getConnection();
    $sql = "INSERT INTO requisicoes (setor_id, requestor_id, total_cost, setor_id));
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    $statement->bind_param(
        'iiifi',
        $data['setor_id'],
        $data['requestor_id'],
        $data['total_cost'],
        $data['setor_id']
    );
    $statement->execute();
    $lastInsertId = $connection->insert_id;
    foreach ($produtos as $produto) {
        $subtotal = $produto['quantidade'] * $produto['preco_unitario'];
        $this->addProdutoToRequisicao($lastInsertId, $produto['produto_id'], $produto['quantidade']);
    }
    $connection->close();
}

public function addProdutoToRequisicao($requisicaoId, $produtoId, $quantidade, $subtotal)
{
    $db = new DatabaseController();
    $connection = $db->getConnection();
    $sql = "INSERT INTO requisicao_produtos (requisicao_id, produto_id, quantidade, subtotal) VALUES (:requisicao_id, :produto_id, :quantidade, :subtotal)";
    $statement = $connection->prepare($sql);
    
    $statement->bindValue(':requisicao_id', $requisicaoId, PDO::PARAM_INT);
    $statement->bindValue(':produto_id', $produtoId, PDO::PARAM_INT);
    $statement->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
    $statement->bindValue(':subtotal', $subtotal, PDO::PARAM_STR); // Assuming subtotal is a float or string
    
    $statement->execute();
    $connection = null;
}
}

?>