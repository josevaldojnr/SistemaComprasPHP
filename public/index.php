<?php 
require_once __DIR__ . '/../src/Controllers/Router.php';
session_start();

$router = new Router();

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
            $router->login();
            exit;
        }
        header('Location: /dashboard');

        break;
   case '/login':
    if ($method === 'POST') {
        $router->login();
    } else {
        $router->showLogin();
    }
    break;

    case '/logout':   
        $router->logout();
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