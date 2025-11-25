@extends('layout')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-gray-800">Usuários</h1>

{{-- ✅ MENSAGENS DE SUCESSO/ERRO --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('errors'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        @foreach(session('errors')->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Função</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      @php
        $roles = [
           1 => 'Requisitante',
           2 => 'Pricing',
           3 => 'Compras',
           4 => 'Gerente',
           5 => 'Administrador',
        ];
      @endphp

      @forelse ($users as $user)
        <tr>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $roles[$user->role_id] ?? 'Desconhecido' }}</td>
          <td class="px-6 py-4 text-sm">
            @if ($user->is_active)
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Ativo</span>
            @else
              <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Inativo</span>
            @endif
          </td>
          <td class="px-6 py-4 text-sm text-right space-x-2">

            <a href="{{ route('users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
            
            <a href="{{ route('users.delete', ['id' => $user->id]) }}" 
               class="text-red-600 hover:text-red-900" 
               onclick="return confirm('Tem certeza que deseja desativar este usuário?')">
               Excluir
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum usuário encontrado.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
