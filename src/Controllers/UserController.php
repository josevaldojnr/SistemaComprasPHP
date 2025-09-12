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

          public function login(): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';

        $connector = new DatabaseController('0.0.0.0:3306', 'root', '', 'sistema_compras');
        $statement = $connector->getConnection()->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
        $statement->bind_param("ss", $user, $pass);
        $statement->execute();
        $queryResult = $statement->get_result();
                

        if ($queryResult->num_rows > 0) {
            $_SESSION['user'] = $user;
            $_SESSION['is_auth'] = true;  
            session_regenerate_id(true);
            header('Location: /dashboard');
            return new User($queryResult->fetch_assoc());
        }

            $_SESSION['login_erro'] = "Usuário ou senha inválidos";
            header('Location: /login');
            
    }

    public function logout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: /login');
        exit;
    }
    }
        

?>