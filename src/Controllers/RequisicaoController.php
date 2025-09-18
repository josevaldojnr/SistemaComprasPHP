<?php
require_once __DIR__ . '/../Models/Requisicao.php';
require_once __DIR__ . '/DatabaseController.php';
    class RequisicaoController {


        public function openRequest(User $user, Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare('INSERT INTO requisicao(requestor_id, total_cost,status_id) VALUES (?,?,?)');
            $statement->bind_param('idi',$user->id,$request->total_cost,1);
            $statement->execute();
            $request->id=$connection->insert_id;
            $connection->close();
            $request->requestor_id=$user->id;
            $request->status_id=1;
        }

        public function updateRequestPricer(User $user, Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET pricing_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id, 2 ,$request->id);
            $statement->execute();
            $connection->close();
            $request->pricing_id=$user->id;
            $request->status_id=2;
        }

        public function updateRequestBuyer(User $user, Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET compras_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id, 3,$request->id);
            $statement->execute();
            $connection->close();
            $request->buyer_id=$user->id;
            $request->status_id=3;
        }

         public function approveRequest(User $user, Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET gerente_id = ?, status_id = ?  WHERE id = ?");
            $statement->bind_param('iii',$user->id, 4, $request->id);
            $statement->execute();
            $connection->close();
            $request->manager_id=$user->id;
            $request->status_id=4;
        }

        public function rejectRequest(User $user, Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET gerente_id = ?, status_id = ? WHERE id = ?");
            $statement->bind_param('iii',$user->id,5 ,$request->id);
            $statement->execute();
            $connection->close();
            $request->manager_id=$user->id;
            $request->status_id=5;
        }

            public function cancelRequest(Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET status_id = ? WHERE id = ?");
            $statement->bind_param('ii',6,$request->id);
            $statement->execute();
            $connection->close();
            $request->status_id=6;
        }

        public function finishRequest(Requisicao $request): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET status_id = ? WHERE id = ?");
            $statement->bind_param('ii',7,$request->id);
            $statement->execute();
            $connection->close();
            $request->status_id=7;
        }
        

        public function updateRequestStatus (int $status_id, User $user, Requisicao $request):void{
            switch($status_id){
                case 1:
                    if($user->isRequisitante()){
                        $this->openRequest($user, $request);
                    }else{
                        throw new Exception('ERRO U001 : Usuário sem role definida');
                    }
                break;
                case 2:
                    if(($user->isPricing() && $request->isRequested())|| $user->isAdmin() ){
                        $this->updateRequestPricer($user, $request);
                    }else{
                        throw new Exception('ERRO R001: Usuário sem permissão ou Requisição fora do status previsto -Requisitado-');
                    }
                break;
                case 3:
                    if(($user->isCompras() && $request->isPriced())|| $user->isAdmin()){
                        $this->updateRequestBuyer($user, $request);
                    }else{
                        throw new Exception('ERRO R002: Usuário sem permissão ou Requisição fora do status previsto -Precificado-');
                    }
                break;
                case 4:
                    if(($user->isGerente() && $request->isOrdered())|| $user->isAdmin()){
                        $this->approveRequest($user, $request);
                    }else{
                        throw new Exception('ERRO R003: Usuário sem permissão ou Requisição fora do status previsto -Pedido de Compra Gerado-');
                    }
                break;
                case 5:
                    if($user->isGerente()|| $user->isAdmin()){
                        $this->rejectRequest($user, $request);
                    }else {
                        throw new Exception('ERRO R101: Usuário sem permissão');
                    }                    
                break;
                case 6:
                    if (($request->requestor_id == $user->id)|| $user->isAdmin()){
                        $this->cancelRequest($request);
                    }else{
                        throw new Exception('ERRO R004: Requisição não pertence ao usuário');
                    }
                break;
                case 7:
                    if(($request->requestor_id == $user->id && $request->isApproved()) || $user->isAdmin()){
                        $this->finishRequest($request);
                    }else{
                        throw new Exception('ERRO R004: Requisição não pertence ao usuário');
                    }
                break;
            }   
            
        }
    }
?>