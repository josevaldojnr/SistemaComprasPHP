@extends('layout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
  <h1 class="text-2xl font-bold text-gray-700 mb-4">Setores</h1>

  {{-- Registration Form --}}
  <form method="POST" action="{{ route('sectors.store') }}" class="mb-6">
    @csrf
    <div class="flex flex-col md:flex-row gap-4 items-center">
      <div>
        <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Setor</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        @error('nome')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      <div>
        <label for="user_responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
        <select name="user_responsavel_id" id="user_responsavel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          <option value="">-- Nenhum --</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_responsavel_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
          @endforeach
        </select>
        @error('user_responsavel_id')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      <div class="self-end">
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Criar Setor</button>
      </div>
    </div>
  </form>

  {{-- Sectors List --}}
  @if($sectors->count())
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($sectors as $setor)
            <tr>
              <td class="px-6 py-4">{{ $setor->id }}</td>
              <td class="px-6 py-4">{{ $setor->nome }}</td>
              <td class="px-6 py-4">
                @if($setor->responsavel)
                  {{ $setor->responsavel->name }} ({{ $setor->responsavel->email }})
                @else
                  <span class="text-gray-400">Sem responsável</span>
                @endif
              </td>
              <td class="px-6 py-4 text-right space-x-2">
                <a href="{{ route('sectors.edit', $setor->id) }}"
                   class="px-3 py-1 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600">Editar</a>
                <form action="{{ route('sectors.destroy', $setor->id) }}" method="POST" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este setor?');"
                          class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600">Excluir</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @else
    <p class="text-gray-500">Nenhum setor encontrado.</p>
  @endif
</div>
@endsection
