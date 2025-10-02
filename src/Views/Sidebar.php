<?php
$user = $_SESSION['user'] ?? 'U';
$initial = strtoupper(substr($user, 0, 1));
?>

<aside x-data="{ collapsed: false }"
       :class="collapsed ? 'w-16' : 'w-64'"
       class="h-screen bg-gray-900 text-gray-200 flex flex-col transition-all duration-300">

  <!-- Topo + botão toggle -->
  <div class="h-16 flex items-center justify-between px-4 border-b border-gray-700">
    <span x-show="!collapsed" class="font-bold text-lg">Sisbuy</span>
    <button @click="collapsed = !collapsed" class="text-gray-400 hover:text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M4 6h16M4 12h16M4 18h7"/>
      </svg>
    </button>
  </div>

  <!-- Usuário -->
  <div class="p-4 border-b border-gray-700" x-show="!collapsed">
    <div class="w-16 h-16 rounded-full bg-blue-500 mx-auto flex items-center justify-center text-2xl font-bold text-white">
      <?= $initial ?>
    </div>
    <p class="mt-2 text-center font-medium"><?= htmlspecialchars($user); ?></p>
    <span class="block text-xs text-center text-gray-400">
      <?= htmlspecialchars($_SESSION['role'] ?? 'Usuário'); ?>
    </span>
    <a href="/logout"
       class="mt-3 block text-center bg-red-500 py-1.5 rounded hover:bg-red-600">
      Sair
    </a>
  </div>

  <!-- Menu -->
  <nav class="flex-1 overflow-y-auto p-2">
    <ul class="space-y-2">

      <!-- Solicitações -->
      <li x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12h6m-6 4h6m-6-8h6M5 6h14v12H5z"/>
          </svg>
          <span x-show="!collapsed" class="flex-1 text-left">Solicitações</span>
        </button>
        <ul x-show="open && !collapsed" class="ml-10 mt-1 space-y-1 text-sm">
          <li><a href="?page=nova-solicitacao" class="block py-1 hover:text-blue-400">Nova solicitação</a></li>
          <li><a href="?page=minhas-solicitacoes" class="block py-1 hover:text-blue-400">Minhas solicitações</a></li>
          <li><a href="?page=acompanhamento" class="block py-1 hover:text-blue-400">Acompanhamento</a></li>
        </ul>
      </li>

      <!-- Compras -->
      <li x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 4h18M3 10h18M9 16h12M9 20h12"/>
          </svg>
          <span x-show="!collapsed" class="flex-1 text-left">Compras</span>
        </button>
        <ul x-show="open && !collapsed" class="ml-10 mt-1 space-y-1 text-sm">
          <li><a href="?page=pedidos-compra" class="block py-1 hover:text-blue-400">Pedidos de compra</a></li>
          <li><a href="?page=fornecedores" class="block py-1 hover:text-blue-400">Fornecedores</a></li>
        </ul>
      </li>

      <!-- Cadastros -->
      <li x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v12m6-6H6"/>
          </svg>
          <span x-show="!collapsed" class="flex-1 text-left">Cadastros</span>
        </button>
        <ul x-show="open && !collapsed" class="ml-10 mt-1 space-y-1 text-sm">
          <li><a href="?page=setores" class="block py-1 hover:text-blue-400">Setores</a></li>
          <li><a href="?page=itens" class="block py-1 hover:text-blue-400">Itens</a></li>
          <li><a href="?page=categorias" class="block py-1 hover:text-blue-400">Categorias</a></li>
        </ul>
      </li>

      <!-- Administração -->
      <li x-data="{ open: false }">
        <button @click="open = !open"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-800 transition">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <span x-show="!collapsed" class="flex-1 text-left">Administração</span>
        </button>
        <ul x-show="open && !collapsed" class="ml-10 mt-1 space-y-1 text-sm">
          <li><a href="?page=usuarios" class="block py-1 hover:text-blue-400">Usuários</a></li>
          <li><a href="?page=obz" class="block py-1 hover:text-blue-400">OBZ</a></li>
        </ul>
      </li>

    </ul>
  </nav>
</aside>
