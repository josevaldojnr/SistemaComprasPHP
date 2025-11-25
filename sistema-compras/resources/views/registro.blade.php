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

        {{-- ERROS DE VALIDAÇÃO --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-3 text-sm text-red-700 dark:text-red-100 border border-red-200 dark:border-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MENSAGEM DE SUCESSO --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-3 text-sm text-green-700 dark:text-green-100 border border-green-200 dark:border-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Usuário</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    value="{{ old('username') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                           text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    placeholder="seu.usuario">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                           text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    placeholder="jose123@mail.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                           text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    placeholder="••••••••">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                    Confirmar Senha
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700
                           text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2"
                    placeholder="••••••••">
            </div>

            <div class="space-y-3">
                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 px-4 rounded-lg transition font-medium">
                    Cadastrar
                </button>

                <a
                    href="{{ route('login.form') }}"
                    class="w-full text-center block bg-gray-200 hover:bg-gray-300 text-gray-800 py-2.5 px-4 rounded-lg transition font-medium">
                    Já tenho uma conta
                </a>
            </div>
        </form>
    </div>

</body>
</html>
