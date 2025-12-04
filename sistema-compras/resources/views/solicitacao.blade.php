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
                <!-- Produtos selecionados serão renderizados via JS -->
            </tbody>
        </table>
    <h4 class="mt-4">Total: R$ <span id="total">0,00</span></h4>
    <input type="hidden" name="products_json" id="products-json">
    </div>
  </div>


  <div class="flex justify-end gap-3 pt-4">
    <a href="{{ route('dashboard') }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-600 rounded-md hover:bg-gray-100 transition">Cancelar</a>
    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">Salvar</button>
  </div>
</form>

<script>
    // Array to hold selected products
    let selectedProducts = [];

    // Add product to array or update quantity if already exists
    document.querySelectorAll('.add-product').forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.parentElement;
            const productId = productItem.getAttribute('data-id');
            const productPrice = parseFloat(productItem.getAttribute('data-price'));
            const productName = productItem.childNodes[0].textContent.trim();

            let existing = selectedProducts.find(p => p.id === productId);
            if (existing) {
                existing.quantity += 1;
            } else {
                selectedProducts.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1
                });
            }
            renderSelectedProducts();
        });
    });

    // Render selected products table from array
    function renderSelectedProducts() {
        const tbody = document.getElementById('selected-products');
        tbody.innerHTML = '';
        selectedProducts.forEach((product, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900\">${product.name}</td>
                <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">
                    <input type='number' value='${product.quantity}' min='1' class='quantity' data-idx='${idx}' style='width:60px;'>
                </td>
                <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">R$ ${product.price.toFixed(2).replace('.', ',')}</td>
                <td class=\"px-6 py-4 whitespace-nowrap text-sm text-gray-500\">
                    R$ <span class='subtotal'>${(product.price * product.quantity).toFixed(2).replace('.', ',')}</span>
                </td>
                <td class=\"px-6 py-4 whitespace-nowrap text-sm font-medium\">
                    <button type='button' class='remove-product text-indigo-600 hover:text-indigo-900' data-idx='${idx}'>Remover</button>
                </td>
            `;
            tbody.appendChild(row);
        });
        updateTotal();
        attachRowEvents();
    }

    // Attach events to quantity inputs and remove buttons
    function attachRowEvents() {
        document.querySelectorAll('.quantity').forEach(input => {
            input.addEventListener('input', function() {
                const idx = parseInt(this.getAttribute('data-idx'));
                let val = parseInt(this.value) || 1;
                selectedProducts[idx].quantity = val;
                renderSelectedProducts();
            });
        });
        document.querySelectorAll('.remove-product').forEach(button => {
            button.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-idx'));
                selectedProducts.splice(idx, 1);
                renderSelectedProducts();
            });
        });
    }

    // Update total value
    function updateTotal() {
        const totalElement = document.getElementById('total');
        let total = 0;
        selectedProducts.forEach(product => {
            total += product.price * product.quantity;
        });
        totalElement.textContent = total.toFixed(2).replace('.', ',');
    }

    // Serialize array as JSON before submit
    document.getElementById('requisition-form').addEventListener('submit', function(e) {
        document.getElementById('products-json').value = JSON.stringify(selectedProducts);
    });
</script>
@endsection
