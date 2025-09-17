<?php
    //STATUS
    //1 = requisitado
    //2 = precificado
    //3 = pedido de compra gerado
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

         public function __construct($queryResult=null, User $user) {
            if(!is_array($queryResult)) {
                $this->id = 0;
                $this->requestor_id = $user->id;
                $this->pricing_id = 0;
                $this->purchasing_id = 0;
                $this->manager_id = 0;
                $this->total_cost = 0;
                $this->status_id = 0;
                return;
            }
            $this->id = $queryResult['id'];
            $this->requestor_id = $queryResult['requestor_id'];
            $this->pricing_id = $queryResult['pricing_id'];
            $this->purchasing_id = $queryResult['purchasing_id'];
            $this->manager_id = $queryResult['manager_id'];
            $this->total_cost = $queryResult['total_cost'];
            $this->status_id = $queryResult['status_id'];
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

    public function isOrderCreated():bool{
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

}

?>