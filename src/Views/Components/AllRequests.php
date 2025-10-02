<?php
require_once __DIR__ . '/../../Models/Requisicao.php';
$requests = Requisicao::getAll(); 
?>

<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
  }

  th, td {
    padding: 12px;
    border: 1px solid #ddd;
  }

  th {
    background-color: #f4f4f4;
    font-weight: bold;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #f1f1f1;
  }
</style>

<table>
  <thead>
    <tr>
      <th>REQUISITANTE</th>
      <th>STATUS</th>
      <th>CUSTO TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($requests)): ?>
      <?php foreach ($requests as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row->requestor_name) ?></td>
          <td><?= htmlspecialchars($row->status_name) ?></td>
          <td>R$<?= number_format($row->total_cost, 2, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="3" style="text-align:center;">Nenhuma requisição encontrada</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>