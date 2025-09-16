<?php
    //STATUS
    //1 = requisitado
    //2 = precificado
    //3 = pedido de compra gerado
    //4 = aprovado
    //5 = rejeitado
    //6 = cancelado
    //7 = finalizado 


    class Requisicao{
        public int $id;
        public int $requestor_id;
        public int $pricing_id;
        public int $purchasing_id;
        public int $manager_id;
        public int $total_cost;
        public int $status;
        public string $created_at;

         public function __construct($queryResult=null) {
            if(!is_array($queryResult)) {
                $this->id = 0;
                $this->requestor_id = 0;
                $this->pricing_id = 0;
                $this->purchasing_id = 0;
                $this->manager_id = 0;
                $this->total_cost = 0;
                $this->status = 0;
                $this->created_at = '';
                return;
            }
            $this->id = $queryResult['id'];
            $this->requestor_id = $queryResult['requestor_id'];
            $this->pricing_id = $queryResult['pricing_id'];
            $this->purchasing_id = $queryResult['purchasing_id'];
            $this->manager_id = $queryResult['manager_id'];
            $this->total_cost = $queryResult['total_cost'];
            $this->status = $queryResult['status'];
            $this->created_at = $queryResult['created_at'];
    }

    public function isRequested(): bool {
        if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 1;
    }

    public function isPriced():bool{
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 2;
    }

    public function isOrderCreated():bool{
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->statys === 3;
    }

    public function isApproved():bool{
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 4;
    }

    public function isRejected():bool{
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 5;
    }

    public function isCanceled():bool{
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 6;
    }

    public function isFinished(){
         if($this->status>7 || $this->status<1){
             throw new Exception("Status Desconhecido");
        }
        return $this->status === 7;
    }

}

?>