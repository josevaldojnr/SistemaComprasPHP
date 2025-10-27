<?php

?>

<h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Usuário</h1>

<form method="post" action="/users/updateUser">
  <input type="hidden" name="id" value="<?= $user['id'] ?>" />
  
  <label>Nome</label>
  <input type="text" name="nome" value="<?= htmlspecialchars($user['name']) ?>" required class="w-full border rounded px-3 py-2 mb-4" />

  <label>Email</label>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full border rounded px-3 py-2 mb-4" />

  <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Salvar</button>
</form>
