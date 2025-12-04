<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Sisbuy Compras')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="h-screen flex bg-gray-100">

  <!-- SIDEBAR -->
  <aside class="w-72 bg-white border-r shadow-md flex flex-col">

    <div class="p-6 border-b flex items-center space-x-3">

      <!-- Avatar -->
      <div class="h-10 w-10 flex items-center justify-center rounded-full bg-indigo-600 text-white font-bold">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      </div>

      <div>
        <h1 class="text-lg font-bold text-indigo-600">Sisbuy Compras</h1>
        <p class="text-sm text-gray-500">Olá, {{ auth()->user()->name }}</p>
      </div>
    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2">

    <a href="{{ route('dashboard') }}"
      class="block px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
      Dashboard
    </a>

      <!-- Solicitações -->
      <div x-data="{ open: false }">
        <button @click="open = !open"
          class="w-full flex justify-between items-center px-3 py-2 rounded-md text-gray-700 hover:bg-indigo-100">
          Solicitações
          <svg :class="open ? 'rotate-90' : ''" class="h-4 w-4 transform transition-transform"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>

        <div x-show="open" x-transition class="ml-4 mt-1 space-y-1">
          <a href="{{ route('requisitions.create') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Nova Solicitação</a>
          <a href="{{ route('requisitions.index') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Minhas Solicitações</a>
        </div>
      </div>

      <!-- Cadastros -->
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
          <a href="{{ route('products.index') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Produtos</a>
          <a href="{{ route('categories.index') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Categorias</a>
          <a href="{{ route('sectors.index') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Setores</a>
        </div>
      </div>

      <!-- Administração -->
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
          <a href="{{ route('users.index') }}" class="block px-3 py-1 text-sm text-gray-600 hover:text-indigo-600">Usuários</a>
        </div>
      </div>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full px-3 py-2 rounded-md bg-red-500 text-white hover:bg-red-600">
          Sair
        </button>
      </form>
    </div>
  </aside>

  <!-- ÁREA PRINCIPAL -->
  <main class="flex-1 overflow-y-auto p-6">
    @yield('content')
  </main>

</body>
</html><!doctype html>

