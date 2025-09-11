<?php
namespace Src\Controllers;

class AutenticacaoController {
    public function LoginForm(): void {
        require __DIR__ . '/../Views/Auth/Login.php';
    }

    public function login(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            echo "<pre>LOGIN FOI CHAMADO!\n";
            print_r($_POST);
            echo "</pre>";
            exit;

        $user = trim($_POST['username'] ?? '');
        $pass = (string)($_POST['password'] ?? '');

        if ($user === 'admin' && $pass === '123') {
            $_SESSION['user'] = $user;
            $_SESSION['is_auth'] = true;  
            session_regenerate_id(true);

            require __DIR__ . '/../Views/Dashboard/Index.php';
            exit;
        }

        $_SESSION['login_erro'] = "Usuário ou senha inválidos";
        require __DIR__ . '/../Views/Auth/Login.php';
        exit;
    }

    public function logout(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $_SESSION = [];
        session_destroy();

        require __DIR__ . '/../Views/Auth/Login.php';
        exit;
    }
}
