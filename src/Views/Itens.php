<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$itens = [
    ["id" => 1, "nome" => "Notebook Dell", "categoria" => "Tecnologia"],
    ["id" => 2, "nome" => "Cadeira Ergonômica", "categoria" => "Móveis"],
    ["id" => 3, "nome" => "Papel A4", "categoria" => "Escritório"],
    ["id" => 4, "nome" => "Monitor LG 24", "categoria" => "Tecnologia"],
];
?>

<div class="bg-white shadow-md rounded-lg p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-700">Itens</h1>
    <a href="/itens/create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
      Criar Item
    </a>
  </div>

  <?php if (!empty($itens)): ?>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($itens as $item): ?>
          <tr>
            <td class="px-6 py-4"><?= $item['id'] ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($item['nome']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($item['categoria']) ?></td>
            <td class="px-6 py-4 flex gap-2">
              <a href="/itens/edit?id=<?= $item['id'] ?>"
                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600 transition">
                Editar
              </a>
              <a href="/itens/delete?id=<?= $item['id'] ?>"
                class="px-3 py-1 bg-red-500 text-white text-sm rounded-full hover:bg-red-600 transition">
                Excluir
              </a>
          </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-gray-500">Nenhum item encontrado.</p>
  <?php endif; ?>
</div>
