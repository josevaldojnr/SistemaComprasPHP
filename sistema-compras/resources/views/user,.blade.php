<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) exit;


require_once __DIR__ . '/../Controllers/DatabaseController.php';
require_once __DIR__ . '/../Controllers/UserController.php';

$db = new DatabaseController();
$userController = new UserController();

$users = $userController->getAllUsers();

?>

<h1 class="text-2xl font-bold mb-6 text-gray-800">Usuários</h1>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Função</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <?php foreach ($users as $user): ?>
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700"><?= $user['id'] ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($user['name']) ?></td>
          <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($user['email']) ?></td>
          <?php 
          $roles = [
              1 => 'Requisitante',
              2 => 'Pricing',
              3 => 'Compras',
              4 => 'Gerente',
              5 => 'Administrador',
          ];
          ?>
          <td class="px-6 py-4 text-sm text-gray-700"><?= $roles[$user['role_id']] ?? 'Desconhecido' ?></td>
          <td class="px-6 py-4 text-sm">
            <?php if ($user['is_active']): ?>
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
            <?php else: ?>
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
            <?php endif; ?>
          </td>
          <td class="px-6 py-4 text-sm text-right space-x-2">
            <a href="/users/edit?id=<?= $user['id'] ?>" class="text-indigo-600 hover:text-indigo-900">Editar</a>
            <a href="/users/delete?id=<?= $user['id'] ?>" class="text-red-600 hover:text-red-900">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
