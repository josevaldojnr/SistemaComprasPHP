<?php
require_once __DIR__ . '/../../Models/Requisicao.php';
$requests = Requisicao::getAll(); 
?>

<table>
<?php
  if(!empty($requests)):
    foreach($requests as $row):
?>
    <tr>
        <td><?= $row->id?></td>
        <td><?= htmlspecialchars($row->requestor_name)?></td>
        <td><?= htmlspecialchars($row->status_name)?></td>
        <td>R$<?= $row->total_cost?></td>
    </tr>
<?php
    endforeach;
    else:
?>
    <tr>
        <td colspan="4" style="text-align:center;">Nenhuma requisição encontrada</td>
    </tr>
<?php endif;?>
</table>