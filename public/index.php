<?php 
require_once __DIR__ . '/../src/Controllers/Router.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';    
session_start();

$router = new Router();
$user = new User();

$path = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

switch ($path) {
    case '/dashboard':
        if (!empty($_SESSION['user'])) {
            $router->showDashboard();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/':
        if($method ==="POST"){
            $user=$user->login();
            exit;
        }
        header('Location: /dashboard');

        break;
   case '/login':
    if(!empty($_SESSION['user'])){
        header('Location: /dashboard');
        exit;
    }
    if ($method === 'POST') {
        $user=$user->login();
    } else {
        $router->showLogin();
    }
    break;

    case '/logout':   
        $user->logout();
        break;

    case '/products':
        echo "Products page";
        break;

    case '/purchases':
        echo "Purchases page";
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada!";
}

?>