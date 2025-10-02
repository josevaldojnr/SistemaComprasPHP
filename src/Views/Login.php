<?php
session_start();
$erro = $_SESSION['login_erro'] ?? null;
unset($_SESSION['login_erro']);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sisbuy Compras</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script> tailwind.config = { darkMode: 'media' } </script>
</head>
<body class="h-full flex items-center justify-center bg-gray-100 dark:bg-gray-900">

  <div class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
      Sisbuy Compras
    </h2>

    <?php if ($erro): ?>
      <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-3 text-sm text-red-700 dark:text-red-100 border border-red-200 dark:border-red-700">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="/login" class="space-y-5">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Usuário</label>
        <input type="text" id="email" name="email" required
          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
          placeholder="jose123@mail.com">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
        <input type="password" id="password" name="password" required
          class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
          placeholder="••••••••">
      </div>

      <div class="flex justify-center space-x-3">
        <button type="submit"
          class="bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 px-4 rounded-lg transition font-medium">
          Entrar
        </button>

        <a href="/register"
          class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2.5 px-4 rounded-lg transition font-medium">
          Criar uma conta
        </a>
      </div>
    </form>
  </div>

</body>
</html>
