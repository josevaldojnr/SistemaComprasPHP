<?php
//ROLES
//1 = requisitante
//2 = pricing
//3 = compras
//4 = gerente
//5 = admin
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
            $this->role = $queryResult['role'];
          
        }

        public function isAdmin(): bool {
            if ($this->role === 5 ){
                return true;
            }
            return false;
        }
    }
?>