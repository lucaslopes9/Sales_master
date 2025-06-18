<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Vendas') }}
        </h2>

        {{-- Botão para Cadastrar Novo Cliente --}}
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            1-Cadastrar Novo Cliente
        </a>

        {{-- Botão para Cadastrar Novo Produto --}}
        <a href="{{ route('produtos.create') }}" class="btn btn-primary">
            2-Cadastrar Novo Produto
        </a>

          <div class="mt-4">
                        <a href="{{ route('vendas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Ver Lista de Vendas
                        </a>


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-0">
                        <div class="card">
                            <div class="card-header">
                                <h1>Registrar Nova Venda</h1>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('vendas.store') }}" method="POST">
                                    @csrf

                                    {{-- Campo de Cliente: Atualizado para incluir o modal --}}
                                    <div class="mb-3">
                                        <label for="cliente_id_hidden" class="form-label">Cliente (Opcional)</label>
                                        <div class="input-group">
                                            {{-- Campo visível para exibir o nome/razão social do cliente selecionado --}}
                                            <input type="text" class="form-control" id="cliente_nome_display" placeholder="Selecione um Cliente" readonly>
                                            {{-- Campo oculto para armazenar o ID do cliente que será enviado ao backend --}}
                                            <input type="hidden" id="cliente_id_hidden" name="cliente_id">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#clientesModal">
                                                Selecionar Cliente
                                            </button>
                                        </div>
                                    </div>
                                    {{-- Fim do campo de Cliente --}}

                                    <h4 class="mt-4">Itens da Venda</h4>
                                    <div id="itens-container">
                                        <div class="row item-venda mb-3 border p-2 rounded">
                                            <div class="col-md-5">
                                                <label for="produto_0_display" class="form-label">Produto</label>
                                                <div class="input-group">
                                                    {{-- Campo visível para exibir o nome do produto selecionado --}}
                                                    <input type="text" class="form-control produto-nome-display" id="produto_0_display" placeholder="Selecione um Produto" readonly>
                                                    {{-- Campo oculto para armazenar o ID do produto que será enviado ao backend --}}
                                                    <input type="hidden" class="produto-id-hidden" name="itens[0][produto_id]" required>
                                                    <button type="button" class="btn btn-outline-secondary seleccionar-produto-btn" data-index="0" data-bs-toggle="modal" data-bs-target="#produtosModal">
                                                        Selecionar Produto
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="quantidade_0" class="form-label">Quantidade</label>
                                                <input type="number" class="form-control quantidade-item" id="quantidade_0" name="itens[0][quantidade]" min="1" value="1" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="valor_unitario_0" class="form-label">Valor Unitário</label>
                                                <input type="number" class="form-control valor-unitario-item" id="valor_unitario_0" name="itens[0][valor_unitario]" step="0.01" min="0.01" value="0.00" required>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remover-item">X</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="adicionar-item">Adicionar Item</button>

                                    {{-- CAMPO TOTAL DA VENDA --}}
                                    <div class="mt-4 p-3 bg-light border rounded">
                                        <h4>Total da Venda: <span id="total-venda">R$ 0,00</span></h4>
                                        <input type="hidden" id="total_venda_hidden" name="total_venda">
                                    </div>

                                    <div class="mb-3 mt-4">
                                        <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                                        <select class="form-select" id="forma_pagamento" name="forma_pagamento" required>
                                            <option value="">Selecione...</option>
                                            <option value="cartao_credito">Cartão de Crédito</option>
                                            <option value="cartao_debito">Cartão de Débito</option>
                                            <option value="dinheiro">Dinheiro</option>
                                            <option value="pix">PIX</option>
                                        </select>
                                    </div>

                                    <div id="parcelas-section" style="display: none;">
                                        <h4 class="mt-4">Parcelas</h4>
                                        <div id="parcelas-container">
                                            <div class="row parcela-item mb-3 border p-2 rounded">
                                                <div class="col-md-6">
                                                    <label for="parcela_valor_0" class="form-label">Valor da Parcela</label>
                                                    <input type="number" class="form-control parcela-valor" id="parcela_valor_0" name="parcelas[0][valor]" step="0.01" min="0.01" value="0.00">
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="parcela_data_vencimento_0" class="form-label">Data de Vencimento</label>
                                                    <input type="date" class="form-control parcela-data-vencimento" id="parcela_data_vencimento_0" name="parcelas[0][data_vencimento]">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm remover-parcela">X</button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="adicionar-parcela">Adicionar Parcela</button>

                                        {{-- CAMPO TOTAL DAS PARCELAS E MENSAGEM DE ERRO --}}
                                        <div class="mt-3 p-3 bg-light border rounded">
                                            <h4>Total das Parcelas: <span id="total-parcelas">R$ 0,00</span></h4>
                                            <div id="parcelas-error-message" class="text-danger mt-2" style="display: none;">
                                                A soma das parcelas não pode ultrapassar o valor total da venda!
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-4" id="registrar-venda-btn">Registrar Venda</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE SELEÇÃO DE CLIENTES --}}
    <div class="modal fade" id="clientesModal" tabindex="-1" aria-labelledby="clientesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientesModalLabel">Selecionar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchCliente" placeholder="Pesquisar por Razão Social ou Nome Fantasia">
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Razão Social</th>
                                <th>Nome Fantasia</th>
                                <th>Logradouro</th>
                                <th>Número</th>
                                <th>Limite</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="clientesTableBody">
                            {{-- Clientes serão carregados aqui via JavaScript --}}
                            <tr>
                                <td colspan="6" class="text-center">Carregando clientes...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- FIM DO MODAL CLIENTES --}}

    {{-- MODAL DE SELEÇÃO DE PRODUTOS --}}
    <div class="modal fade" id="produtosModal" tabindex="-1" aria-labelledby="produtosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produtosModalLabel">Selecionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchProduto" placeholder="Pesquisar por Nome ou Descrição">
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody id="produtosTableBody">
                            {{-- Produtos serão carregados aqui via JavaScript --}}
                            <tr>
                                <td colspan="5" class="text-center">Carregando produtos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- FIM DO MODAL PRODUTOS --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            let itemIndex = 1;
            let parcelaIndex = 1;
            let currentProductInputIndex = 0; // Para saber qual input de produto o modal deve preencher

            // 1. Funções de Cálculo e Validação
            function calculateTotalVenda() {
                let total = 0;
                $('.item-venda').each(function() {
                    const quantidade = parseFloat($(this).find('.quantidade-item').val()) || 0;
                    const valorUnitario = parseFloat($(this).find('.valor-unitario-item').val()) || 0;
                    total += (quantidade * valorUnitario);
                });
                $('#total-venda').text('R$ ' + total.toFixed(2).replace('.', ','));
                $('#total_venda_hidden').val(total.toFixed(2)); // Atualiza o campo hidden
                validateParcelas(); // Valida parcelas sempre que o total da venda muda
            }

            function calculateTotalParcelas() {
                let total = 0;
                $('.parcela-item').each(function() {
                    const valorParcela = parseFloat($(this).find('.parcela-valor').val()) || 0;
                    total += valorParcela;
                });
                $('#total-parcelas').text('R$ ' + total.toFixed(2).replace('.', ','));
                validateParcelas(); // Valida parcelas sempre que o total das parcelas muda
            }

            function validateParcelas() {
                const totalVenda = parseFloat($('#total_venda_hidden').val()) || 0;
                const totalParcelas = parseFloat($('#total-parcelas').text().replace('R$', '').replace(',', '.')) || 0;
                const formaPagamento = $('#forma_pagamento').val();

                if (formaPagamento === 'cartao_credito' && totalParcelas > totalVenda) {
                    $('#parcelas-error-message').show();
                    $('#registrar-venda-btn').prop('disabled', true); // Desabilita o botão de submit
                } else {
                    $('#parcelas-error-message').hide();
                    $('#registrar-venda-btn').prop('disabled', false); // Habilita o botão de submit
                }
            }


            // 2. Lógica para adicionar/remover itens da venda
            $('#adicionar-item').click(function() {
                const newItem = `
                    <div class="row item-venda mb-3 border p-2 rounded">
                        <div class="col-md-5">
                            <label for="produto_${itemIndex}_display" class="form-label">Produto</label>
                            <div class="input-group">
                                <input type="text" class="form-control produto-nome-display" id="produto_${itemIndex}_display" placeholder="Selecione um Produto" readonly>
                                <input type="hidden" class="produto-id-hidden" name="itens[${itemIndex}][produto_id]" required>
                                <button type="button" class="btn btn-outline-secondary selecionar-produto-btn" data-index="${itemIndex}" data-bs-toggle="modal" data-bs-target="#produtosModal">
                                    Selecionar Produto
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="quantidade_${itemIndex}" class="form-label">Quantidade</label>
                            <input type="number" class="form-control quantidade-item" id="quantidade_${itemIndex}" name="itens[${itemIndex}][quantidade]" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label for="valor_unitario_${itemIndex}" class="form-label">Valor Unitário</label>
                            <input type="number" class="form-control valor-unitario-item" id="valor_unitario_${itemIndex}" name="itens[${itemIndex}][valor_unitario]" step="0.01" min="0.01" value="0.00" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remover-item">X</button>
                        </div>
                    </div>
                `;
                $('#itens-container').append(newItem);
                itemIndex++;
                calculateTotalVenda(); // Recalcula o total da venda ao adicionar item
            });

            $(document).on('click', '.remover-item', function() {
                $(this).closest('.item-venda').remove();
                calculateTotalVenda(); // Recalcula o total da venda ao remover item
            });

            // Eventos para recalcular o total da venda quando quantidade ou valor unitário mudam
            $(document).on('input', '.quantidade-item, .valor-unitario-item', function() {
                calculateTotalVenda();
            });

            // 3. Lógica para mostrar/esconder a seção de parcelas
            $('#forma_pagamento').change(function() {
                const formaPagamento = $(this).val();
                if (formaPagamento === 'cartao_credito') {
                    $('#parcelas-section').show();
                    $('#parcelas-section input.parcela-valor').prop('required', true); // Valore da parcela é obrigatório
                    $('#parcelas-section input.parcela-data-vencimento').prop('required', true); // Data de vencimento é obrigatória
                    calculateTotalParcelas(); // Calcula total das parcelas ao mostrar a seção
                } else {
                    $('#parcelas-section').hide();
                    $('#parcelas-section input').prop('required', false);
                    $('#parcelas-error-message').hide(); // Esconde a mensagem de erro se a forma de pagamento mudar
                    $('#registrar-venda-btn').prop('disabled', false); // Habilita o botão de submit
                    // Opcional: Limpar campos de parcela ao esconder
                    $('.parcela-item').not(':first').remove(); // Remove parcelas adicionais
                    $('#parcela_valor_0').val('0.00'); // Reseta o primeiro campo de parcela
                    $('#parcela_data_vencimento_0').val(''); // Reseta o campo de data
                    calculateTotalParcelas(); // Zera o total das parcelas
                }
            });

            // 4. Lógica para adicionar/remover parcelas
            $('#adicionar-parcela').click(function() {
                const newParcela = `
                    <div class="row parcela-item mb-3 border p-2 rounded">
                        <div class="col-md-6">
                            <label for="parcela_valor_${parcelaIndex}" class="form-label">Valor da Parcela</label>
                            <input type="number" class="form-control parcela-valor" id="parcela_valor_${parcelaIndex}" name="parcelas[${parcelaIndex}][valor]" step="0.01" min="0.01" value="0.00" required>
                        </div>
                        <div class="col-md-5">
                            <label for="parcela_data_vencimento_${parcelaIndex}" class="form-label">Data de Vencimento</label>
                            <input type="date" class="form-control parcela-data-vencimento" id="parcela_data_vencimento_${parcelaIndex}" name="parcelas[${parcelaIndex}][data_vencimento]" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remover-parcela">X</button>
                        </div>
                    </div>
                `;
                $('#parcelas-container').append(newParcela);
                parcelaIndex++;
                calculateTotalParcelas(); // Recalcula o total das parcelas ao adicionar
            });

            $(document).on('click', '.remover-parcela', function() {
                $(this).closest('.parcela-item').remove();
                calculateTotalParcelas(); // Recalcula o total das parcelas ao remover
            });

            // Eventos para recalcular o total das parcelas quando o valor da parcela muda
            $(document).on('input', '.parcela-valor', function() {
                calculateTotalParcelas();
            });

            // --- LÓGICA PARA SELEÇÃO DE CLIENTES VIA MODAL ---
            let clientsData = [];

            $('#clientesModal').on('show.bs.modal', function () {
                if (clientsData.length === 0) {
                    loadClientes();
                } else {
                    renderClientesTable(clientsData);
                }
            });

            function loadClientes(searchQuery = '') {
                $('#clientesTableBody').html('<tr><td colspan="6" class="text-center">Carregando clientes...</td></tr>');
                $.ajax({
                    url: '{{ route('api.clientes.index') }}',
                    method: 'GET',
                    data: { search: searchQuery },
                    success: function(response) {
                        clientsData = response;
                        renderClientesTable(clientsData);
                    },
                    error: function(xhr) {
                        $('#clientesTableBody').html('<tr><td colspan="6" class="text-center text-danger">Erro ao carregar clientes: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Desconhecido') + '</td></tr>');
                        console.error("Erro ao carregar clientes:", xhr.responseText);
                    }
                });
            }

            function renderClientesTable(clientes) {
                let tableRows = '';
                if (clientes.length === 0) {
                    tableRows = '<tr><td colspan="6" class="text-center">Nenhum cliente encontrado.</td></tr>';
                } else {
                    clientes.forEach(function(cliente) {
                        tableRows += `
                            <tr>
                                <td>${cliente.razao_social || 'N/A'}</td>
                                <td>${cliente.nome_fantasia || 'N/A'}</td>
                                <td>${cliente.logradouro || 'N/A'}</td>
                                <td>${cliente.numero || 'N/A'}</td>
                                <td>R$ ${parseFloat(cliente.limite_credito || 0).toFixed(2).replace('.', ',')}</td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm selecionar-cliente"
                                        data-id="${cliente.id}"
                                        data-razao-social="${cliente.razao_social || ''}"
                                        data-nome-fantasia="${cliente.nome_fantasia || ''}">
                                        Selecionar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#clientesTableBody').html(tableRows);
            }

            $('#searchCliente').on('keyup', function() {
                const query = $(this).val().toLowerCase();
                const filteredClients = clientsData.filter(cliente =>
                    (cliente.razao_social && cliente.razao_social.toLowerCase().includes(query)) ||
                    (cliente.nome_fantasia && cliente.nome_fantasia.toLowerCase().includes(query))
                );
                renderClientesTable(filteredClients);
            });

            $(document).on('click', '.selecionar-cliente', function() {
                const clienteId = $(this).data('id');
                const razaoSocial = $(this).data('razao-social');
                const nomeFantasia = $(this).data('nome-fantasia');

                $('#cliente_id_hidden').val(clienteId);
                $('#cliente_nome_display').val(razaoSocial || nomeFantasia);

                $('#clientesModal').modal('hide');
            });
            // --- FIM DA LÓGICA DE CLIENTES ---

            // --- LÓGICA PARA SELEÇÃO DE PRODUTOS VIA MODAL ---
            let productsData = [];

            $('#produtosModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                currentProductInputIndex = button.data('index');

                if (productsData.length === 0) {
                    loadProdutos();
                } else {
                    renderProdutosTable(productsData);
                }
            });

            function loadProdutos(searchQuery = '') {
                $('#produtosTableBody').html('<tr><td colspan="5" class="text-center">Carregando produtos...</td></tr>');
                $.ajax({
                    url: '{{ route('api.produtos.index') }}',
                    method: 'GET',
                    data: { search: searchQuery },
                    success: function(response) {
                        productsData = response;
                        renderProdutosTable(productsData);
                    },
                    error: function(xhr) {
                        $('#produtosTableBody').html('<tr><td colspan="5" class="text-center text-danger">Erro ao carregar produtos: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Desconhecido') + '</td></tr>');
                        console.error("Erro ao carregar produtos:", xhr.responseText);
                    }
                });
            }

            function renderProdutosTable(produtos) {
                let tableRows = '';
                if (produtos.length === 0) {
                    tableRows = '<tr><td colspan="5" class="text-center">Nenhum produto encontrado.</td></tr>';
                } else {
                    produtos.forEach(function(produto) {
                        tableRows += `
                            <tr>
                                <td>${produto.nome || 'N/A'}</td>        <!-- Corrigido para produto.nome -->
                                <td>${produto.descricao || 'N/A'}</td>  <!-- Corrigido para produto.descricao -->
                                <td>R$ ${parseFloat(produto.preco || 0).toFixed(2).replace('.', ',')}</td> <!-- Corrigido para produto.preco -->
                                <td>${produto.estoque || 0}</td>           <!-- Corrigido para produto.estoque -->
                                <td>
                                    <button type="button" class="btn btn-success btn-sm selecionar-produto"
                                        data-id="${produto.id}"
                                        data-name="${produto.nome || ''}"        <!-- Corrigido para produto.nome -->
                                        data-price="${produto.preco || '0.00'}"> <!-- Corrigido para produto.preco -->
                                        Selecionar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#produtosTableBody').html(tableRows);
            }

            $('#searchProduto').on('keyup', function() {
                const query = $(this).val().toLowerCase();
                const filteredProducts = productsData.filter(produto =>
                    (produto.nome && produto.nome.toLowerCase().includes(query)) ||
                    (produto.descricao && produto.descricao.toLowerCase().includes(query))
                );
                renderProdutosTable(filteredProducts);
            });

            $(document).on('click', '.selecionar-produto', function() {
                const produtoId = $(this).data('id');
                const produtoNome = $(this).data('name');
                const produtoPreco = $(this).data('price');

                $(`#produto_${currentProductInputIndex}_display`).val(produtoNome);
                $(`input[name="itens[${currentProductInputIndex}][produto_id]"]`).val(produtoId);
                $(`#valor_unitario_${currentProductInputIndex}`).val(parseFloat(produtoPreco).toFixed(2));

                calculateTotalVenda(); // Recalcula o total da venda ao selecionar um produto
                $('#produtosModal').modal('hide');
            });
            // --- FIM DA LÓGICA DE PRODUTOS ---

            // Inicializar cálculos ao carregar a página
            calculateTotalVenda();
            calculateTotalParcelas();
        });
    </script>
</x-app-layout>