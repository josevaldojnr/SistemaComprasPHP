@extends('layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Minhas Solicitações</h1>
        <a href="{{ route('requisitions.create') }}" class="px-5 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
            Nova Solicitação
        </a>
    </div>

    @if($requisitions->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <p class="text-yellow-800">Você não tem nenhuma solicitação registrada. <a href="{{ route('requisitions.create') }}" class="font-semibold underline">Crie uma</a></p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($requisitions as $requisition)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Solicitação #{{ $requisition->id }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Setor: <span class="font-medium text-gray-900">{{ $requisition->setor }}</span>
                            </p>
                            @if($requisition->description)
                                <p class="text-sm text-gray-600 mt-2">{{ $requisition->description }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">
                                Criada em: {{ $requisition->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                @if($requisition->status_id == 1)
                                    bg-blue-100 text-blue-800
                                @elseif($requisition->status_id == 2)
                                    bg-yellow-100 text-yellow-800
                                @elseif($requisition->status_id == 3)
                                    bg-green-100 text-green-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ $requisition->status_id == 1 ? 'Pendente' : ($requisition->status_id == 2 ? 'Aprovada' : ($requisition->status_id == 3 ? 'Concluída' : 'Desconhecido')) }}
                            </span>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Produtos</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unitário</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($requisition->products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $product->product->nome }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $product->quantidade }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                R$ {{ number_format($product->price, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                R$ {{ number_format($product->subtotal, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Total and Status Button -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Total da Solicitação:</p>
                            <p class="text-2xl font-bold text-indigo-600">
                                R$ {{ number_format($requisition->products->sum('subtotal'), 2, ',', '.') }}
                            </p>
                        </div>
                        <form action="{{ route('requisitions.updateStatus', $requisition->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                                Atualizar Status
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($requisitions->hasPages())
            <div class="mt-8">
                {{ $requisitions->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
