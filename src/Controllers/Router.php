<?php
require_once __DIR__ . '/DatabaseController.php';
class Router {

    public function showLogin(): void {
       require __DIR__ . '/../Views/Login.php';
   }

   public function showDashboard(): void {
       require __DIR__ . '/../Views/Dashboard.php';
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
            $this->showDashboard();
            exit;
        }

            $_SESSION['login_erro'] = "Usuário ou senha inválidos";
            $this->showLogin();
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
