<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$view = $view ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Sisbuy Compras</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-screen flex bg-gray-100">

  <aside class="w-72 bg-white border-r shadow-md flex flex-col">
    <div class="p-6 border-b flex items-center space-x-3">
      <div class="h-10 w-10 flex items-center justify-center rounded-full bg-indigo-600 text-white font-bold">
        <?= strtoupper(substr($_SESSION['user'], 0, 1)) ?>
      </div>
      <div>
        <h1 class="text-lg font-bold text-indigo-600">Sisbuy Compras</h1>
        <p class="text-sm text-gray-500">Olá, <?= htmlspecialchars($_SESSION['user']); ?></p>
      </div>
    </div>

    <nav class="flex-1 p-4 space-y-2">

      <div x-data="{ open: false }">

      <a href="/dashboard"
             class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">Dashboard</a>
        <button @click="open = !open"
        
          class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
          Solicitações
          <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
          <a href="/nova-solicitacao"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Nova Solicitação</a>
          <a href="/minhas-solicitacoes"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Minhas Solicitações</a>
          <a href="/acompanhamento"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Acompanhamento</a>
        </div>
      </div>

      <div x-data="{ open: false }">
        <button @click="open = !open"
          class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
          Compras
          <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
          <a href="/solicitacoes-compra" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Solicitações de Compra</a>
          <a href="/pedidos-compra"
             @click.prevent="fetch('/pedidos-compra').then(r => r.text()).then(h => html = h); page='/pedidos-compra'"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Pedidos de Compra</a>
        </div>
      </div>

      <div x-data="{ open: false }">
        <button @click="open = !open"
          class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
          Cadastros
          <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
          <a href="/setores"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Setores</a>
          <a href="/itens"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Itens</a>
          <a href="/fornecedores"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Fornecedores</a>
          <a href="/categorias"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Categorias</a>
        </div>
      </div>

      <div x-data="{ open: false }">
        <button @click="open = !open"
          class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
          Administração
          <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
          <a href="/users"
             class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Usuários</a>
        </div>
      </div>
    </nav>

    <div class="p-4 border-t">
      <a href="/logout" class="block text-center px-3 py-2 rounded-md bg-red-500 text-white hover:bg-red-600">Sair</a>
    </div>
  </aside>

  <main class="flex-1 overflow-y-auto p-6">
    <?php if ($view && file_exists(__DIR__ . '/' . $view)): ?>
      <?php include __DIR__ . '/' . $view; ?>
    <?php else: ?>
      <p>View not found.</p>
    <?php endif; ?>
  </main>

</body>
</html>
