<?php
//ROLES
//1 = requisitante
//2 = pricing
//3 = compras
//4 = gerente
//5 = admin
require_once __DIR__ . '/../Controllers/DatabaseController.php';
    class User {
        public int $id;
        public string $name;
        public string $email;
        public string $password;
        public int $role;

        public function __construct($queryResult=null) {
            if(!is_array($queryResult)) {
                $this->id = 0;
                $this->name = '';
                $this->email = '';
                $this->password = '';
                $this->role = 0;
                return;
            }
            $this->id = $queryResult['id'];
            $this->name = $queryResult['name'];
            $this->email = $queryResult['email'];
            $this->password = $queryResult['password'];
            $this->role = $queryResult['role_id'];
          
        }

        public function isAdmin(): bool {
            if($this->role > 5 || $this->role < 1){
               throw new Exception("Role não designada");
            }
            if ($this->role === 5 ){
                return true;
            }
            return false;
        }

        public function isGerente(): bool {
            if($this->role > 5 || $this->role < 1){
               throw new Exception("Role não designada");
            }
            if ($this->role === 4 ){
                return true;
            }
            return false;
        }

        public function isCompras(): bool {
            if($this->role > 5 || $this->role < 1){
               throw new Exception("Role não designada");
            }
            if ($this->role === 3 ){
                return true;
            }
            return false;
        }

        public function isPricing(): bool {
            if($this->role > 5 || $this->role < 1){
               throw new Exception("Role não designada");
            }
            if ($this->role === 2 ){
                return true;
            }
            return false;
        }

        public function isRequisitante(): bool {
            if($this->role > 5 || $this->role < 1){
               throw new Exception("Role não designada");
            }
            if ($this->role === 1 ){
                return true;
            }
            return false;
        }

    }
?>