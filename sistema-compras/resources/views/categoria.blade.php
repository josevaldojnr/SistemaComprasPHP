@extends('layout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">

  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">Categorias</h1>
    <form action="{{ route('categories.store') }}" method="POST" class="flex gap-2 items-center">
      @csrf
      <input type="text" name="nome" placeholder="Nova categoria" required class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-indigo-500">
      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Adicionar</button>
    </form>
    @if ($errors->any())
      <div class="mt-2 text-red-600 text-sm">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif
  </div>

  @if(isset($categories) && $categories->count())
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($categories as $cat)
          <tr>
            <td class="px-6 py-4">{{ $cat->id }}</td>
            <td class="px-6 py-4">{{ $cat->nome }}</td>
            <td class="px-6 py-4 flex justify-end gap-2">
              <a href="{{ route('categories.edit', $cat->id) }}"
                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600 transition">
                Editar
              </a>
              <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');"
                  class="px-3 py-1 bg-red-500 text-white text-sm rounded-full hover:bg-red-600 transition">Excluir</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="text-gray-500">Nenhuma categoria encontrada.</p>
  @endif
</div>
@endsection
