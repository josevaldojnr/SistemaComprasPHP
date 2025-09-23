<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$condicoes = [
  ["id" => 1, "nome" => "À Vista"],
  ["id" => 2, "nome" => "30 dias"],
  ["id" => 3, "nome" => "Parcelado em 3x"],
  ["id" => 4, "nome" => "Parcelado em 6x"],
];
?>

<div class="bg-white shadow-md rounded-lg p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-700">Condição de Pagamento</h1>
    <a href="/condicao-pagamento/create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
      Criar Condição
    </a>
  </div>

  <?php if (!empty($condicoes)): ?>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($condicoes as $c): ?>
          <tr>
            <td class="px-6 py-4"><?= $c['id'] ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($c['nome']) ?></td>
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
    <p class="text-gray-500">Nenhuma condição encontrada.</p>
  <?php endif; ?>
</div>
