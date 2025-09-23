<?php
require_once __DIR__ . '/DatabaseController.php';
class Router {

    public function showLogin(): void {
       require __DIR__ . '/../Views/Login.php';
   }

   public function showDashboard(): void {
       require __DIR__ . '/../Views/Dashboard.php';
   }

   public function showRegister(): void {
       require __DIR__ . '/../Views/Register.php';
   }

   public function showNovaSolicitacao(): void {
        require __DIR__ . '/../Views/NovaSolicitacao.php';
    }
    public function showUsers(): void {
        require __DIR__ . '/../Views/Users.php';
    }
    public function showSetores(): void {
    require __DIR__ . '/../Views/Setores.php';
    }
    public function showItens(): void {
    require __DIR__ . '/../Views/Itens.php';
    }
    public function showCategorias(): void {
    require __DIR__ . '/../Views/Categorias.php';
    }
    public function showFornecedores(): void {
    require __DIR__ . '/../Views/Fornecedores.php';
    }
    public function showCondicao(): void {
    require __DIR__ . '/../Views/CondicaoPagamento.php';
    }
    
}
