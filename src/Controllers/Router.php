<?php

class Router {

    public function showLogin(): void {
       require __DIR__ . '/../Views/Login.php';
   }

   public function showDashboard(): void {
       require __DIR__ . '/../Views/Dashboard.php';
   }
    public function LoginForm(): void {
        require __DIR__ . '/../Views/Login.php';
    }

    public function login(): bool {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';

        if ($user === 'admin' && $pass === '123') {
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
