<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

require_once __DIR__ . "/../Controllers/DatabaseController.php";

$db = new DatabaseController();
$conn = $db->getConnection();

try {
    $stmt = $conn->prepare("
        SELECT s.*, u.email AS email_responsavel
        FROM setores s
        LEFT JOIN users u ON s.user_responsavel_id = u.id
    ");
    $stmt->execute();
    $setores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $setores = [];
    $error = $e->getMessage();
}
?>

<div class="bg-white shadow-md rounded-lg p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-700">Setores</h1>
    <a href="/setores/create" 
       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
      Criar Setor
    </a>
  </div>

  <?php if (!empty($error)): ?>
    <p class="text-red-500"><?= $error ?></p>
  <?php endif; ?>

  <?php if (!empty($setores)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teto Gestor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teto Diretoria</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach ($setores as $setor): ?>
            <tr>
              <td class="px-6 py-4"><?= $setor['id'] ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($setor['nome']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($setor['email_responsavel'] ?? 'Sem responsável') ?></td>
              <td class="px-6 py-4">R$ <?= number_format($setor['teto_gestor'], 2, ',', '.') ?></td>
              <td class="px-6 py-4">R$ <?= number_format($setor['teto_diretoria'], 2, ',', '.') ?></td>
              <td class="px-6 py-4 text-right space-x-2">
                <a href="/setores/edit?id=<?= $setor['id'] ?>"
                   class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600">
                  Editar
                </a>
                <a href="/setores/delete?id=<?= $setor['id'] ?>"
                   onclick="return confirm('Tem certeza que deseja excluir este setor?');"
                   class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600">
                  Excluir
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-gray-500">Nenhum setor encontrado.</p>
  <?php endif; ?>
</div>
