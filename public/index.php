<?php 
require_once __DIR__ . '/../src/Controllers/Router.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';
session_start();

$router = new Router();
$userController = new UserController();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

switch ($path) {

    case '/':
        if (!empty($_SESSION['user'])) {
            header('Location: /dashboard');
            exit;
        } else {
            header('Location: /login');
            exit;
        }
        break;

    case '/dashboard':
        if (!empty($_SESSION['user'])) {
            $router->showDashboard();
        } else {
            header('Location: /login');
            exit;
        }
        break;
        
    case '/users':
        if (!empty($_SESSION['user'])) {
            $router->showUsers();
        } else {
            $router->showLogin();
            exit;
        }
        break;

    case '/nova-solicitacao':
        if (!empty($_SESSION['user'])) {
            $router->showNovaSolicitacao();
        } else {
            $router->showLogin();
            exit;
        }
        break;

    case '/login':
        if (!empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        if ($method === 'POST') {
            $userController->login();
        } else {
            $router->showLogin();
        }
        break;

    case '/logout':
        $userController->logout();
        break;

    case '/products':
        echo "Products page";
        break;

    case '/purchases':
        echo "Purchases page";
        break;

    case '/register':
        if (!empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        if ($method === 'POST') {
            $userController->register();
        } else {
            $router->showRegister();
        }
        break;
    case '/setores':
        if (!empty($_SESSION['user'])) {
            $router->showSetores();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/itens':
        if (!empty($_SESSION['user'])) {
            $router->showItens();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/categorias':
        if (!empty($_SESSION['user'])) {
            $router->showCategorias();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/fornecedores':
        if (!empty($_SESSION['user'])) {
            $router->showFornecedores();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/users/delete':
        if (!empty($_SESSION['user'])) {
            $userController->deleteUser();
            header('Location:/logout');
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/users/edit':
        if (!empty($_SESSION['user'])) {
            $router->showEditUser();
        } else {
            header('Location: /login');
            exit;
        }
        break;
    case '/users/updateUser':
        if (!empty($_SESSION['user'])) {
            $userController->updateUser(); 
        } else {
            header('Location: /login');
            exit;
        }
        break;
    default:
        http_response_code(404);
        echo "Página não encontrada!";
}
