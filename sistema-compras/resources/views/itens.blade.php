
@extends('layout')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
  <form action="{{ route('products.store') }}" method="POST" class="mb-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" id="nome" name="nome" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>
      <div>
        <label for="preco" class="block text-sm font-medium text-gray-700">Preço</label>
        <input type="number" id="preco" name="preco" step="0.01" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
      </div>
      <div>
        <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoria</label>
        <select id="categoria_id" name="categoria_id" required
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          <option value="">Selecione...</option>
          @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex items-end">
        <button type="submit"
          class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          Adicionar Produto
        </button>
      </div>
    </div>
  </form>

  @if($itens->count() > 0)
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preço</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($itens as $item)
          <tr>
            <td class="px-6 py-4">{{ $item->id }}</td>
            <td class="px-6 py-4">{{ $item->nome }}</td>
            <td class="px-6 py-4">R$ {{ number_format($item->preco, 2, ',', '.') }}</td>
            <td class="px-6 py-4">{{ $item->categoria->nome ?? '' }}</td>
            <td class="px-6 py-4 flex gap-2">
              <a href="{{ route('products.edit', $item->id) }}"
                class="px-3 py-1 bg-blue-500 text-white text-sm rounded-full hover:bg-blue-600 transition">
                Editar
              </a>
              <form action="{{ route('products.destroy', $item->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded-full hover:bg-red-600 transition">Excluir</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="text-gray-500">Nenhum produto encontrado.</p>
  @endif
</div>
@endsection
