<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/DatabaseController.php';

class UserController {
    private $dbController;

    public function __construct() {
        $this->dbController = new DatabaseController();
    }

    public function login(): User {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $email = trim($_POST['email']) ?? '';
        $pass = $_POST['password'] ?? '';

        $db = new DatabaseController();
        $statement = $db->getConnection()->prepare('SELECT * FROM users WHERE email = :email AND is_active = 1');
        $statement->bindValue(':email', $email); // Correctly bind the email parameter
        $statement->execute();
        $userData = $statement->fetch(PDO::FETCH_ASSOC); // Fetch single user data
        $db->closeConnection();
            
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

    public function register(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        
        $user = trim($_POST['username']) ?? '';
        $pass = $_POST['password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';
        $email = trim($_POST['email']) ?? '';

        if ($pass !== $confirmPass) {
            $_SESSION['register_erro'] = "As senhas não coincidem";
            header('Location: /register');
            exit;
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_erro'] = "Email inválido";
            header('Location: /register');
            exit;
        }

        if ($user === '' || strlen($user) < 4) {
            $_SESSION['register_erro'] = "Nome de usuário deve ter pelo menos 4 caracteres";
            header('Location: /register');
            exit;
        }

        if ($pass === '' || strlen($pass) < 6) {
            $_SESSION['register_erro'] = "A senha deve ter pelo menos 6 caracteres";
            header('Location: /register');
            exit;
        }

        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        $db = new DatabaseController();
        $conn = $db->getConnection();

        try {
            // Check if the email already exists
            $stmt = $conn->prepare('SELECT id FROM users WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['register_erro'] = "Email já está em uso";
                header('Location: /register');
                exit;
            }

            // Get the user count
            $stmtCount = $conn->prepare('SELECT COUNT(*) FROM users');
            $stmtCount->execute();
            $userCount = $stmtCount->fetchColumn(); // Fetch the count directly

            $roleId = ($userCount == 0) ? 5 : 1; 

            // Insert new user
            $includeStatement = $conn->prepare('INSERT INTO users (name, email, password, role_id, is_active) VALUES (:name, :email, :password, :role_id, 1)');
            $includeStatement->bindParam(':name', $user);
            $includeStatement->bindParam(':email', $email);
            $includeStatement->bindParam(':password', $hashedPass);
            $includeStatement->bindParam(':role_id', $roleId, PDO::PARAM_INT);

            if ($includeStatement->execute()) {
                $_SESSION['register_success'] = "Usuário registrado com sucesso. Faça login.";
                header('Location: /login');
                exit;
            } else {
                $_SESSION['register_erro'] = "Erro ao registrar usuário. Tente novamente.";
                header('Location: /register');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['register_erro'] = "Erro ao registrar: " . $e->getMessage();
            header('Location: /register');
            exit;
        } finally {
            $db->closeConnection();
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

    public function deleteUser(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header('Location: /users');
            exit;
        }

        $id = (int)$_GET['id'];

        $db = new DatabaseController();
        $conn = $db->getConnection();

        $stmt = $conn->prepare('UPDATE users SET is_active = 0 WHERE id = ? AND is_active = 1');
        $stmt->bindValue(1, $id); 
        $stmt->execute();
        $stmt->close();
        $db->closeConnection();

        $_SESSION['delete_msg'] = "Usuário deletado com sucesso";

        header('Location: /users');
        exit;
    }
    public function updateUser(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $name = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $roleId = intval($_POST['funcao']);
            $newSetorId = intval($_POST['setor_id']);
            $status = $_POST['status'] === 'ativo' ? 1 : 0;

            $db = new DatabaseController();
            $conn = $db->getConnection();
            $conn->beginTransaction();

            try {
                $stmtOldSetor = $conn->prepare("SELECT setor_id FROM users WHERE id = :id LIMIT 1");
                $stmtOldSetor->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtOldSetor->execute();
                $row = $stmtOldSetor->fetch(PDO::FETCH_ASSOC);
                $oldSetorId = $row ? intval($row['setor_id']) : null;

                // Update user information
                $stmtUser = $conn->prepare(
                    "UPDATE users SET name = :name, email = :email, role_id = :role_id, setor_id = :setor_id, is_active = :is_active WHERE id = :id"
                );
                $stmtUser->bindParam(':name', $name);
                $stmtUser->bindParam(':email', $email);
                $stmtUser->bindParam(':role_id', $roleId, PDO::PARAM_INT);
                $stmtUser->bindParam(':setor_id', $newSetorId, PDO::PARAM_INT);
                $stmtUser->bindParam(':is_active', $status, PDO::PARAM_INT);
                $stmtUser->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtUser->execute();

                // Update the new setor
                $stmtSetorNovo = $conn->prepare("UPDATE setores SET user_responsavel_id = :user_id WHERE id = :setor_id");
                $stmtSetorNovo->bindParam(':user_id', $id, PDO::PARAM_INT);
                $stmtSetorNovo->bindParam(':setor_id', $newSetorId, PDO::PARAM_INT);
                $stmtSetorNovo->execute();

                // Clear the old setor if it has changed
                if ($oldSetorId !== null && $oldSetorId !== $newSetorId) {
                    $stmtSetorOld = $conn->prepare("UPDATE setores SET user_responsavel_id = NULL WHERE id = :setor_id");
                    $stmtSetorOld->bindParam(':setor_id', $oldSetorId, PDO::PARAM_INT);
                    $stmtSetorOld->execute();
                }

                $conn->commit();
                $db->closeConnection();

                header('Location: /users');
                exit;

            } catch (Exception $e) {
                $conn->rollBack();
                $db->closeConnection();
                exit("Erro ao atualizar: " . $e->getMessage());
            }
        }
    }
    public function getAllUsers(): array {
        $conn = $this->dbController->getConnection();
        $query = "SELECT * FROM users"; // Adjust the query as needed
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all users as an associative array
    }
}
?>