<?php
require_once __DIR__ . '/DatabaseController.php';
class Router {

    public function showLogin(): void {
       require __DIR__ . '/../Views/Login.php';
   }

   public function showDashboard(): void {
       require __DIR__ . '/../Views/Dashboard.php';
   }

  
}
