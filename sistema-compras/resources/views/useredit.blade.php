<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) exit('Acesso negado.');

require_once __DIR__ . '/../Controllers/DatabaseController.php';

$db = new DatabaseController();

if (!isset($_GET['id'])) {
    exit('ID do usuário não informado.');
}

$id = intval($_GET['id']);

try {
  
    $stmt = $db->getConnection()->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        exit('Usuário não encontrado.');
    }

  
    $stmt = $db->getConnection()->prepare("SELECT id, name FROM roles ORDER BY name");
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

  
    $stmt = $db->getConnection()->prepare("SELECT id, nome FROM setores ORDER BY nome");
    $stmt->execute();
    $setores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    exit('Erro na consulta: ' . $e->getMessage());
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

  <label class="block mb-1 font-semibold">Setor</label>
  <select name="setor_id" required class="w-full border rounded px-3 py-2 mb-4">
    <?php foreach ($setores as $setor): ?>
      <option value="<?= htmlspecialchars($setor['id']) ?>" <?= ($user['setor_id'] == $setor['id']) ? 'selected' : '' ?>>
        <?= htmlspecialchars($setor['nome']) ?>
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
