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

        public function login(): User {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $email = trim($_POST['email']) ?? '';
        $pass = $_POST['password'] ?? '';

        $connector = new DatabaseController('0.0.0.0:3306', 'root', '', 'sistema_compras');
        $statement = $connector->getConnection()->prepare('SELECT * FROM users WHERE email = ? AND is_active = 1');
        $statement->bind_param('s', $email);
        $statement->execute();
        $queryResult = $statement->get_result();
        $userData = $queryResult->fetch_assoc();
                

          if ($userData && password_verify($pass, $userData['password'])) {
            $_SESSION['user'] = $userData['name'];
            $_SESSION['is_auth'] = true;
            session_regenerate_id(true);

            header('Location: /dashboard');
            return new User($userData);
        }

            $_SESSION['login_erro'] = "Usuário ou senha inválidos";
            header('Location: /login');
            return new User();

    }

    public function register():void{
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $user = trim($_POST['username']) ?? '';
        $pass = $_POST['password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';
        $email = trim($_POST['email']) ?? '';
       
        if($pass !== $confirmPass){
            $_SESSION['register_erro'] = "As senhas não coincidem";
            header('Location: /register');
            exit;
        }

        if($email ==='' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['register_erro'] = "Email inválido";
            header('Location: /register');
            exit;
        }

        if($user ==='' || strlen($user) < 4){
            $_SESSION['register_erro'] = "Nome de usuário deve ter pelo menos 4 caracteres";
            header('Location: /register');
            exit;
        }
        if($pass ==='' || strlen($pass) < 6){
            $_SESSION['register_erro'] = "A senha deve ter pelo menos 6 caracteres";
            header('Location: /register');
            exit;
        }

        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        $connector = new DatabaseController('0.0.0.0:3306', 'root', '', 'sistema_compras');


        $checkUserStatement = $connector->getConnection()->prepare('SELECT id FROM users WHERE email = ?');
        $checkUserStatement->bind_param('s', $email);
        $checkUserStatement->execute();
        $queryUser = $checkUserStatement->get_result();
        if($queryUser->num_rows > 0){
            $_SESSION['register_erro'] = "Email já estão em uso";
            header('Location: /register');
            exit;
        }

        $includeStatement = $connector->getConnection()->prepare('INSERT INTO users (name, email, password, role_id, is_active) VALUES (?, ?, ?, 1,1)');
        $includeStatement->bind_param('sss', $user, $email, $hashedPass );  
        
        if($includeStatement->execute()){
            $_SESSION['register_success'] = "Usuário registrado com sucesso. Faça login.";
            header('Location: /login');
            exit;
        } else {
            $_SESSION['register_erro'] = "Erro ao registrar usuário. Tente novamente.";
            header('Location: /register');
            exit;
        }      
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