<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) exit('Acesso negado.');

require_once __DIR__ . '/../Controllers/DatabaseController.php';

$db = new DatabaseController();

if (!isset($_GET['id'])) {
    exit('ID do usuário não informado.');
}

$id = intval($_GET['id']);

$resultUser = $db->executeQuery("SELECT * FROM users WHERE id = $id LIMIT 1");
if (!$resultUser) {
    exit('Erro na consulta do usuário.');
}

$user = $resultUser->fetch_assoc();
if (!$user) {
    exit('Usuário não encontrado.');
}

$resultRoles = $db->executeQuery("SELECT id, name FROM roles ORDER BY name");
if (!$resultRoles) {
    exit('Erro na consulta das funções.');
}

// Converte resultado das roles em array de arrays
$roles = [];
while ($row = $resultRoles->fetch_assoc()) {
    $roles[] = $row;
}
?>

<h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Usuário</h1>

<form method="post" action="/users/updateUser">
  <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>" />

  <label class="block mb-1 font-semibold">Nome</label>
  <input type="text" name="nome" value="<?= htmlspecialchars($user['name']) ?>" required class="w-full border rounded px-3 py-2 mb-4" />

  <label class="block mb-1 font-semibold">Email</label>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full border rounded px-3 py-2 mb-4" />

  <label class="block mb-1 font-semibold">Função</label>
  <select name="funcao" required class="w-full border rounded px-3 py-2 mb-4">
      <?php foreach ($roles as $role): ?>
          <option value="<?= htmlspecialchars($role['id']) ?>" <?= ($user['role_id'] == $role['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars(ucfirst($role['name'])) ?>
          </option>
      <?php endforeach; ?>
  </select>

  <label class="block mb-1 font-semibold">Status</label>
  <select name="status" required class="w-full border rounded px-3 py-2 mb-4">
    <option value="ativo" <?= ($user['is_active']) ? 'selected' : '' ?>>Ativo</option>
    <option value="inativo" <?= (!$user['is_active']) ? 'selected' : '' ?>>Inativo</option>
  </select>

  <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Salvar</button>
</form>
