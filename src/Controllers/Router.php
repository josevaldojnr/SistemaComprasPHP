<?php
require_once __DIR__ . '/DatabaseController.php';
class Router {

    private function renderLayout(string $view): void {
        $viewPath = __DIR__ . '/../Views/' . $view;
        if (file_exists($viewPath)) {
            require __DIR__ . '/../Views/Layout.php';
        } else {
            echo "View not found: " . htmlspecialchars($view);
        }
    }

    public function showLogin(): void {
       require __DIR__ . '/../Views/Login.php';
    }

    public function showDashboard(): void {
        $this->renderLayout('Dashboard.php');
    }

    public function showRegister(): void {
        require __DIR__ . '/../Views/Register.php';
    }

    public function showNovaSolicitacao(): void {
        $this->renderLayout('NovaSolicitacao.php');
    }
    public function showUsers(): void {
        $this->renderLayout('Users.php');
    }
    public function showSetores(): void {
        $this->renderLayout('Setores.php');
    }
    public function showItens(): void {
        $this->renderLayout('Itens.php');
    }
    public function showCategorias(): void {
        $this->renderLayout('Categorias.php');
    }
    public function showFornecedores(): void {
        $this->renderLayout('Fornecedores.php');
    }
    public function showCondicao(): void {
        $this->renderLayout('CondicaoPagamento.php');
    }

   
}
