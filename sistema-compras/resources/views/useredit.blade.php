@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Editar Usuário</h1>
        <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            ← Voltar
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700 text-sm uppercase tracking-wide">Nome</label>
            <input type="text" 
                   name="nome" 
                   value="{{ old('nome', $user->name) }}" 
                   required 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nome') border-red-500 ring-red-500 @enderror"
                   placeholder="Digite o nome completo">
            @error('nome')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700 text-sm uppercase tracking-wide">Email</label>
            <input type="email" 
                   name="email" 
                   value="{{ old('email', $user->email) }}" 
                   required 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 ring-red-500 @enderror"
                   placeholder="email@exemplo.com">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700 text-sm uppercase tracking-wide">Função</label>
            <select name="funcao" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('funcao', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700 text-sm uppercase tracking-wide">Setor</label>
            <select name="setor_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Sem setor</option>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}" {{ old('setor_id', $user->setor_id) == $setor->id ? 'selected' : '' }}>
                        {{ $setor->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-8">
            <label class="block mb-2 font-semibold text-gray-700 text-sm uppercase tracking-wide">Status</label>
            <div class="flex space-x-4">
                <label class="flex items-center">
                    <input type="radio" name="status" value="ativo" {{ old('status', $user->is_active ? 'ativo' : 'inativo') == 'ativo' ? 'checked' : '' }} class="mr-2">
                    <span class="text-green-700 font-medium">Ativo</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="status" value="inativo" {{ old('status', $user->is_active ? 'ativo' : 'inativo') == 'inativo' ? 'checked' : '' }} class="mr-2">
                    <span class="text-red-700 font-medium">Inativo</span>
                </label>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t">
            <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Salvar Alterações
            </button>
            <a href="{{ route('users.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md text-center transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
