<h1 class="text-2xl font-semibold mb-6 text-gray-900">Nova Solicitação</h1>

<form action="salvar_solicitacao.php" method="POST" class="space-y-6 bg-gray-50 border border-gray-200 shadow-sm rounded-lg p-6">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Setor</label>
      <select name="setor_id" required
        class="block w-full rounded-md border border-gray-300 bg-white text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        <option value="">Selecione...</option>
        <option value="1">Financeiro</option>
        <option value="2">TI</option>
        <option value="3">Compras</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Fornecedor</label>
      <select name="fornecedor_id"
        class="block w-full rounded-md border border-gray-300 bg-white text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        <option value="">Selecione...</option>
        <option value="1">Fornecedor A</option>
        <option value="2">Fornecedor B</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Condição de Pagamento</label>
      <select name="condicao_pagamento_id"
        class="block w-full rounded-md border border-gray-300 bg-white text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
        <option value="">Selecione...</option>
        <option value="1">À Vista</option>
        <option value="2">30 dias</option>
        <option value="3">60 dias</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Tipo de Frete</label>
      <input type="text" name="frete" placeholder="Ex: CIF, FOB..."
        class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Nível de Impacto</label>
      <input type="text" name="nivel_impacto" placeholder="Baixo, Médio, Alto..."
        class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-600 mb-1">Prazo Estimado</label>
      <input type="date" name="prazo_estimado"
        class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3
               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-600 mb-1">Descrição</label>
    <textarea name="descricao" rows="3" placeholder="Detalhe a solicitação..."
      class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3
             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-600 mb-1">Observação</label>
    <textarea name="observacao" rows="2" placeholder="Alguma observação extra?"
      class="block w-full rounded-md border border-gray-300 text-sm py-2 px-3
             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
  </div>

  <fieldset class="rounded-md border border-gray-200 bg-white p-4">
    <legend class="text-sm font-medium text-gray-700">Opções adicionais</legend>
    <div class="flex flex-wrap gap-6 mt-3">
      <label class="inline-flex items-center text-sm">
        <input type="checkbox" name="fornecedor_unico"
          class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <span class="ml-2 text-gray-700">Fornecedor Único</span>
      </label>
      <label class="inline-flex items-center text-sm">
        <input type="checkbox" name="imobilizado"
          class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <span class="ml-2 text-gray-700">Imobilizado</span>
      </label>
      <label class="inline-flex items-center text-sm">
        <input type="checkbox" name="compra_emergencial"
          class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <span class="ml-2 text-gray-700">Compra Emergencial</span>
      </label>
    </div>
  </fieldset>

  <div class="flex justify-end gap-3 pt-4">
    <a href="/dashboard"
       class="px-5 py-2 bg-white border border-gray-300 text-gray-600 rounded-md hover:bg-gray-100 transition">
      Cancelar
    </a>
    <button type="submit"
      class="px-5 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
      Salvar
    </button>
  </div>
</form>
