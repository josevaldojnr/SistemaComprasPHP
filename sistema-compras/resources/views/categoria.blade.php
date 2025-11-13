<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$categorias = [
  ["id" => 1, "nome" => "Tecnologia"],
  ["id" => 2, "nome" => "Escritório"],
  ["id" => 3, "nome" => "Móveis"],
  ["id" => 4, "nome" => "Limpeza"],
];
?>

<div class="bg-white shadow-md rounded-lg p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-700">Categorias</h1>
    <a href="/categorias/create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
      Criar Categoria
    </a>
  </div>

  <?php if (!empty($categorias)): ?>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($categorias as $cat): ?>
          <tr>
            <td class="px-6 py-4"><?= $cat['id'] ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($cat['nome']) ?></td>
            <td class="px-6 py-4 flex justify-end gap-2">
              <a href="/setores/edit?id=<?= $setor['id'] ?>"
                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600 transition">
                Editar
              </a>
              <a href="/setores/delete?id=<?= $setor['id'] ?>"
                onclick="return confirm('Tem certeza que deseja excluir este setor?');"
                class="px-3 py-1 bg-red-500 text-white text-sm rounded-full hover:bg-red-600 transition">
                Excluir
              </a>
          </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-gray-500">Nenhuma categoria encontrada.</p>
  <?php endif; ?>
</div>
