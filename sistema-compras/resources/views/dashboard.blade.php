<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) exit?>
<h1 class="text-2xl font-bold mb-4">
  Bem-vindo, <?= htmlspecialchars($_SESSION['user']); ?> 👋
</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
  <h2 class="text-xl font-semibold mb-4">Visão Geral das Requisições</h2>
  <?php require_once __DIR__ . '/Components/AllRequests.php'; ?>
</div>


