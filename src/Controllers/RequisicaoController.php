<?php
require_once __DIR__ . '/../Models/Requisicao.php';
require_once __DIR__ . '/DatabaseController.php';
    class RequisicaoController {


        public function openRequest(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare('INSERT INTO requisicao(requestor_id, ,total_cost,status_id) VALUES (?,?,?)');
            $statement->bind_param('ifi',$user->id,$this->total_cost,1);
            $statement->execute();
            $this->id=$connection->insert_id;
            $connection->close();
            $this->requestor_id=$user->id;
            $this->status_id=1;
        }

        public function updateRequestPricer(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET pricing_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id,$this->id, 2);
            $statement->execute();
            $connection->close();
            $this->pricing_id=$user->id;
            $this->status_id=2;
        }

        public function updateRequestBuyer(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET compras_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id,$this->id, 3);
            $statement->execute();
            $connection->close();
            $this->buyer_id=$user->id;
            $this->status_id=3;
        }

         public function approveRequest(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET gerente_id = ?, status_id = ?  WHERE id = ?");
            $statement->bind_param('iii',$user->id,$this->id,4);
            $statement->execute();
            $connection->close();
            $this->manager_id=$user->id;
            $this->status_id=4;
        }

        public function rejectRequest(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET gerente_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id,5,$this->id);
            $statement->execute();
            $connection->close();
            $this->manager_id=$user->id;
            $this->status_id=5;
        }

            public function cancelRequest(): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET status_id = ? WHERE id = ?");
            $statement->bind_param('ii',6,$this->id);
            $statement->execute();
            $connection->close();
            $this->status_id=6;
        }

        public function finishRequest(): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET status_id = ? WHERE id = ?");
            $statement->bind_param('ii',7,$this->id);
            $statement->execute();
            $connection->close();
            $this->status_id=7;
        }
        

        public function updateRequestStatus (int $status_id, User $user):void{
            switch($status){
                case 1:
                    if($user->role_id > 0 && $user->role_id<6){
                        openRequest($user);
                    }else{
                        throw new Exception('ERRO U001 : Usuário sem role definida');
                    }
                break;
                case 2:
                    if(($user->role_id = 2 && $this->status=1)|| $user->role_id = 5 ){
                        updateRequestPricer($user);
                    }else{
                        throw new Exception('ERRO R001: Usuário sem permissão ou Requisição fora do status previsto -Requisitado-');
                    }
                break;
                case 3:
                    if(($user->role_id = 3 && $this->status=2)|| $user->role_id = 5){
                        updateRequestBuyer($user);
                    }else{
                        throw new Exception('ERRO R002: Usuário sem permissão ou Requisição fora do status previsto -Precificado-');
                    }
                break;
                case 4:
                    if(($user->role_id = 4 && $this->status=3)|| $user->role_id = 5){
                        approveRequest($user);
                    }else{
                        throw new Exception('ERRO R003: Usuário sem permissão ou Requisição fora do status previsto -Pedido de Compra Gerado-');
                    }
                break;
                case 5:
                    if(($user->role_id = 4)|| $user->role_id = 5){
                        rejectRequest($user);
                    }else {
                        throw new Exception('ERRO R101: Usuário sem permissão');
                    }                    
                break;
                case 6:
                    if (($this->requestor_id=$user->id)|| $user->role_id = 5){
                        cancelRequest();
                    }else{
                        throw new Exception('ERRO R004: Requisição não pertence ao usuário');
                    }
                break;
                case 7:
                    if(($this->requestor_id=$user->id && $this->status_id=4 )|| $user->role_id = 5){
                        finishRequest();
                    }else{
                        throw new Exception('ERRO R004: Requisição não pertence ao usuário');
                    }
                break;
            }   
            
        }
    }
?>