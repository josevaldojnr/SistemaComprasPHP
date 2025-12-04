@extends('layout')

@section('content')
<h1 class="text-2xl font-semibold mb-6 text-gray-900">Nova Solicitação</h1>

<form id="requisition-form" action="{{ route('requisitions.store') }}" method="POST" class="space-y-6 bg-gray-50 border border-gray-200 shadow-sm rounded-lg p-6">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Setor</label>
      <select name="setor_id" required class="block w-full rounded-md border border-gray-300 bg-white text-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        <option value="">Selecione...</option>
        @if(isset($sectors))
          @foreach($sectors as $sector)
            <option value="{{ $sector->id }}">{{ $sector->nome }}</option>
          @endforeach
        @endif
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Descrição</label>
      <textarea name="descricao" rows="3" placeholder="Detalhe a solicitação..." class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
    </div>
  </div>

  <div class="border-t border-gray-200 pt-6">
    <label class="block text-sm font-medium text-gray-600 mb-1">Produtos</label>
    <div>
        <h3>Produtos Disponíveis</h3>
        <ul id="product-list">
            @foreach($products as $product)
                <li data-id="{{ $product->id }}" data-price="{{ $product->preco }}">
                    {{ $product->nome }} - R$ {{ number_format($product->preco, 2, ',', '.') }}
                    <button type='button' class='add-product text-indigo-600 hover:text-indigo-900'>Adicionar</button>
                </li>
            @endforeach
        </ul>
    </div>

    <div>
        <h3>Produtos Selecionados</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                </tr>
            </thead>
            <tbody id="selected-products">
                <!-- Os produtos selecionados serão adicionados aqui -->
            </tbody>
        </table>
        <h4 class="mt-4">Total: R$ <span id="total">0,00</span></h4>
    </div>
  </div>


  <div class="flex justify-end gap-3 pt-4">
    <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-600 rounded-md hover:bg-gray-100 transition">Cancelar</a>
    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">Salvar</button>
  </div>
</form>

<script>
    document.querySelectorAll('.add-product').forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.parentElement;
            const productId = productItem.getAttribute('data-id');
            const productPrice = parseFloat(productItem.getAttribute('data-price'));
            const productName = productItem.textContent.trim();

            const selectedProductsTable = document.getElementById('selected-products');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${productName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <input type='number' value='1' min='1' class='quantity' data-id='${productId}' data-price='${productPrice}'>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">R$ ${productPrice.toFixed(2).replace('.', ',')}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    R$ <span class='subtotal'>${productPrice.toFixed(2).replace('.', ',')}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button type='button' class='remove-product text-indigo-600 hover:text-indigo-900'>Remover</button>
                </td>
            `;

            selectedProductsTable.appendChild(newRow);
            updateTotal();

            newRow.querySelector('.remove-product').addEventListener('click', function() {
                selectedProductsTable.removeChild(newRow);
                updateTotal();
            });

            newRow.querySelector('.quantity').addEventListener('input', function() {
                const quantity = parseInt(this.value) || 0;
                const subtotal = (quantity * productPrice).toFixed(2);
                newRow.querySelector('.subtotal').textContent = subtotal.replace('.', ',');
                updateTotal();
            });
        });
    });

    function updateTotal() {
        const totalElement = document.getElementById('total');
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;
        subtotals.forEach(subtotal => {
            total += parseFloat(subtotal.textContent.replace(',', '.'));
        });
        totalElement.textContent = total.toFixed(2).replace('.', ',');
    }

    // Serialize selected products into hidden inputs before submit
    document.getElementById('requisition-form').addEventListener('submit', function(e) {
        // Remove previous hidden inputs if any
        document.querySelectorAll('.product-hidden-input').forEach(el => el.remove());
        const selectedRows = document.querySelectorAll('#selected-products tr');
        selectedRows.forEach((row, idx) => {
            const quantityInput = row.querySelector('.quantity');
            if (quantityInput) {
                const productId = quantityInput.getAttribute('data-id');
                const quantity = quantityInput.value;
                // Create hidden inputs for each product
                let inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = `products[${idx}][id]`;
                inputId.value = productId;
                inputId.classList.add('product-hidden-input');
                this.appendChild(inputId);

                let inputQty = document.createElement('input');
                inputQty.type = 'hidden';
                inputQty.name = `products[${idx}][quantity]`;
                inputQty.value = quantity;
                inputQty.classList.add('product-hidden-input');
                this.appendChild(inputQty);
            }
        });
    });
</script>
@endsection
