<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/DatabaseController.php';

class UserController {

    public function login(): User {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $email = trim($_POST['email']) ?? '';
        $pass = $_POST['password'] ?? '';

        $db = new DatabaseController();
        $statement = $db->getConnection()->prepare('SELECT * FROM users WHERE email = ? AND is_active = 1');
        $statement->bind_param('s', $email);
        $statement->execute();
        $queryResult = $statement->get_result();
        $userData = $queryResult->fetch_assoc();
        $db->closeConnection();
                

          if ($userData && password_verify($pass, $userData['password'])) {
            $_SESSION['user'] = $userData['name'];
            $_SESSION['is_auth'] = true;
            session_regenerate_id(true);

            require __DIR__ . '/../src/Views/Layout.php';
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
        $db = new DatabaseController();


        $connector = $db->getConnection()->prepare('SELECT id FROM users WHERE email = ?');
        $connector->bind_param('s', $email);
        $connector->execute();
        $queryUser = $connector->get_result();
        if($queryUser->num_rows > 0){
            $_SESSION['register_erro'] = "Email já estão em uso";
            header('Location: /register');
            exit;
        }

        $includeStatement = $db->getConnection()->prepare('INSERT INTO users (name, email, password, role_id, is_active) VALUES (?, ?, ?, 1,1)');
        $includeStatement->bind_param('sss', $user, $email, $hashedPass ); 
      
        
        if($includeStatement->execute()){
            $_SESSION['register_success'] = "Usuário registrado com sucesso. Faça login.";
            header('Location: /login');
            $db->closeConnection();
            exit;
        } else {
            $_SESSION['register_erro'] = "Erro ao registrar usuário. Tente novamente.";
            header('Location: /register');
            $db->closeConnection();
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