<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$fornecedores = [
  ["id" => 1, "razao" => "Fornecedor A Ltda", "fantasia" => "Fornecedor A", "email" => "contato@fornecedora.com"],
  ["id" => 2, "razao" => "Fornecedor B S/A", "fantasia" => "Fornecedor B", "email" => "vendas@fornecedorb.com"],
  ["id" => 3, "razao" => "Comercial C Ltda", "fantasia" => "Comercial C", "email" => "suporte@comercialc.com"],
];
?>

<div class="bg-white shadow-md rounded-lg p-6">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold text-gray-700">Fornecedores</h1>
    <a href="/fornecedores/create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
      Criar Fornecedor
    </a>
  </div>

  <?php if (!empty($fornecedores)): ?>
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Razão Social</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome Fantasia</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($fornecedores as $f): ?>
          <tr>
            <td class="px-6 py-4"><?= $f['id'] ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($f['razao']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($f['fantasia']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($f['email']) ?></td>
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
    <p class="text-gray-500">Nenhum fornecedor cadastrado.</p>
  <?php endif; ?>
</div>
