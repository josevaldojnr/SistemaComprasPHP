<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require __DIR__ . '/../DatabaseController.php';
$db = (new DatabaseController())->getConnection();

// Carregar selects
$setores = $db->query("SELECT id, nome FROM setores ORDER BY nome");
$fornecedores = $db->query("SELECT id, nome FROM fornecedores ORDER BY nome");
$itens = $db->query("SELECT id, nome FROM itens ORDER BY nome");

// Mensagens
$erro = $_SESSION['solicitacao_erro'] ?? null;
$sucesso = $_SESSION['solicitacao_sucesso'] ?? null;
unset($_SESSION['solicitacao_erro'], $_SESSION['solicitacao_sucesso']);

// Salvar solicitação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_solicitacao'])) {
    $userId = $_SESSION['user_id'];
    $setor = $_POST['setor_id'];
    $fornecedor = $_POST['fornecedor_id'];
    $link = $_POST['link'] ?? null;
    $impacto = $_POST['impacto'];
    $prazo = "Prazo " . rand(5, 20) . " dias"; // Exemplo randômico
    $mes_pagamento = $_POST['mes_pagamento'] ?? null;
    $emergencial = isset($_POST['compra_emergencial']) ? 1 : 0;
    $conta_obz = $_POST['conta_obz'] ?? null;
    $descricao = $_POST['descricao'] ?? null;
    $observacao = $_POST['observacao'] ?? null;

    // Upload
    $anexo = null;
    if (!empty($_FILES['anexo']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = time() . '_' . basename($_FILES['anexo']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['anexo']['tmp_name'], $targetFile)) {
            $anexo = 'uploads/' . $filename;
        }
    }

    $stmt = $db->prepare("INSERT INTO solicitacoes 
        (user_id, setor_id, fornecedor_id, link, impacto, prazo_estimado, anexo, mes_pagamento, compra_emergencial, conta_obz, descricao, observacao) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssssiiss", $userId, $setor, $fornecedor, $link, $impacto, $prazo, $anexo, $mes_pagamento, $emergencial, $conta_obz, $descricao, $observacao);

    if ($stmt->execute()) {
        $_SESSION['solicitacao_sucesso'] = "Solicitação criada! Agora adicione os produtos.";
        $_SESSION['nova_solicitacao_id'] = $stmt->insert_id;
    } else {
        $_SESSION['solicitacao_erro'] = "Erro ao criar solicitação.";
    }
    header("Location: ?page=nova-solicitacao");
    exit;
}

// Adicionar item à solicitação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_item'])) {
    $solicitacaoId = $_SESSION['nova_solicitacao_id'];
    $itemId = $_POST['item_id'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco_unitario'];

    $stmt = $db->prepare("INSERT INTO solicitacao_itens (solicitacao_id, item_id, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iidd", $solicitacaoId, $itemId, $quantidade, $preco);
    $stmt->execute();

    $_SESSION['solicitacao_sucesso'] = "Item adicionado!";
    header("Location: ?page=nova-solicitacao");
    exit;
}
?>

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-xl font-bold mb-4">Nova Solicitação</h2>

  <!-- Mensagens -->
  <?php if ($erro): ?><div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?= $erro ?></div><?php endif; ?>
  <?php if ($sucesso): ?><div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?= $sucesso ?></div><?php endif; ?>

  <!-- Formulário principal -->
  <?php if (empty($_SESSION['nova_solicitacao_id'])): ?>
  <form method="POST" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="nova_solicitacao" value="1">

    <div>
      <label class="block text-sm">Setor</label>
      <select name="setor_id" required class="w-full border p-2 rounded">
        <option value="">-- Selecione --</option>
        <?php while($s = $setores->fetch_assoc()): ?>
          <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nome']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm">Fornecedor</label>
      <select name="fornecedor_id" required class="w-full border p-2 rounded">
        <option value="">-- Selecione --</option>
        <?php while($f = $fornecedores->fetch_assoc()): ?>
          <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm">Link</label>
      <input type="url" name="link" class="w-full border p-2 rounded">
    </div>

    <div>
      <label class="block text-sm">Nível de Impacto</label>
      <select name="impacto" class="w-full border p-2 rounded">
        <option value="baixo">Baixo</option>
        <option value="medio">Médio</option>
        <option value="alto">Alto</option>
      </select>
    </div>

    <div>
      <label class="block text-sm">Anexo de cotação</label>
      <input type="file" name="anexo" class="w-full border p-2 rounded">
    </div>

    <div>
      <label class="block text-sm">Mês de Pagamento</label>
      <input type="month" name="mes_pagamento" class="w-full border p-2 rounded">
    </div>

    <div class="flex items-center gap-2">
      <input type="checkbox" name="compra_emergencial" id="emergencial" class="h-4 w-4">
      <label for="emergencial">Compra emergencial</label>
    </div>

    <div>
      <label class="block text-sm">Conta OBZ</label>
      <input type="text" name="conta_obz" class="w-full border p-2 rounded">
    </div>

    <div>
      <label class="block text-sm">Descrição detalhada</label>
      <textarea name="descricao" rows="4" class="w-full border p-2 rounded"></textarea>
    </div>

    <div>
      <label class="block text-sm">Observação</label>
      <textarea name="observacao" rows="3" class="w-full border p-2 rounded"></textarea>
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Salvar Solicitação</button>
  </form>

  <?php else: ?>
  <!-- Segunda etapa: adicionar itens -->
  <h3 class="text-lg font-semibold mt-6 mb-2">Adicionar Itens</h3>
  <form method="POST" class="flex gap-2 items-end mb-4">
    <input type="hidden" name="adicionar_item" value="1">
    <select name="item_id" required class="flex-1 border p-2 rounded">
      <option value="">-- Item --</option>
      <?php $itens->data_seek(0); while($i = $itens->fetch_assoc()): ?>
        <option value="<?= $i['id'] ?>"><?= htmlspecialchars($i['nome']) ?></option>
      <?php endwhile; ?>
    </select>
    <input type="number" step="0.01" name="quantidade" placeholder="Qtd" required class="w-24 border p-2 rounded">
    <input type="number" step="0.01" name="preco_unitario" placeholder="Preço" required class="w-32 border p-2 rounded">
    <button class="bg-green-600 text-white px-4 py-2 rounded">Adicionar</button>
  </form>

  <!-- Lista de itens já adicionados -->
  <?php
  $solicitacaoId = $_SESSION['nova_solicitacao_id'];
  $result = $db->query("SELECT si.id, i.nome, si.quantidade, si.preco_unitario 
                        FROM solicitacao_itens si 
                        JOIN itens i ON si.item_id = i.id 
                        WHERE si.solicitacao_id = $solicitacaoId");
  ?>
  <table class="w-full border-collapse border">
    <thead class="bg-gray-100">
      <tr>
        <th class="border p-2">Item</th>
        <th class="border p-2">Qtd</th>
        <th class="border p-2">Preço Unit.</th>
        <th class="border p-2">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; while($row = $result->fetch_assoc()): 
        $subtotal = $row['quantidade'] * $row['preco_unitario']; $total += $subtotal; ?>
        <tr>
          <td class="border p-2"><?= htmlspecialchars($row['nome']) ?></td>
          <td class="border p-2"><?= $row['quantidade'] ?></td>
          <td class="border p-2">R$ <?= number_format($row['preco_unitario'], 2, ',', '.') ?></td>
          <td class="border p-2">R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
        </tr>
      <?php endwhile; ?>
      <tr class="bg-gray-50 font-semibold">
        <td colspan="3" class="border p-2 text-right">Total</td>
        <td class="border p-2">R$ <?= number_format($total, 2, ',', '.') ?></td>
      </tr>
    </tbody>
  </table>
  <?php endif; ?>
</div>
