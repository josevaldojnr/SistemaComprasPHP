<?php
require_once __DIR__ . '/../Models/Requisicao.php';
require_once __DIR__ . '/DatabaseController.php';
    class RequisicaoController {

        public function updateRequestManager(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET gerente_id = ? WHERE id = ?");
            $statement->bind_param('ii',$user->id,$this->id);
            $statement->execute();
        }

        public function updateRequestRequestor(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET requisitante_id = ? WHERE id = ?");
            $statement->bind_param('ii',$user->id,$this->id);
            $statement->execute();
        }

        public function updateRequestPricer(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET pricing_id = ? WHERE id = ?");
            $statement->bind_param('ii',$user->id,$this->id);
            $statement->execute();
        }

        public function updateRequestBuyer(User $user): void {
            $db = new DatabaseController();
            $connection = $db->getConnection(); 
            $statement = $connection->prepare("UPDATE requisicao SET compras_id = ? WHERE id = ?");
            $statement->bind_param('ii',$user->id,$this->id);
            $statement->execute();
        }

        public function updateRequestStatus (int $status, User $user){
            
            
        }
    }
?>