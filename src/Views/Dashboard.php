<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) exit;

ob_start();
?>
<h1 class="text-2xl font-bold mb-4">
  Bem-vindo, <?= htmlspecialchars($_SESSION['user']); ?> 👋
</h1>

<div class="space-y-4">
  <?php require __DIR__ . '/Components/AllRequests.php'; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/Layout.php';
