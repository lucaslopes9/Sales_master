<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Vendas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1>Vendas Registradas</h1>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <a href="{{ route('dashboard') }}" class="btn btn-primary mb-3">Registrar Nova Venda</a>

                        @if ($vendas->isEmpty())
                            <p class="text-center">Nenhuma venda registrada ainda.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID Venda</th>
                                            <th>Data da Venda</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Forma de Pagamento</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vendas as $venda)
                                            <tr>
                                                <td>{{ $venda->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($venda->created_at)->format('d/m/Y H:i') }}</td>
                                                <td>{{ $venda->cliente->razao_social ?? $venda->cliente->nome_fantasia ?? 'Cliente Avulso' }}</td>
                                                <td>R$ {{ number_format($venda->total_venda, 2, ',', '.') }}</td>
                                                <td>
                                                    @switch($venda->forma_pagamento)
                                                        @case('cartao_credito') Cartão de Crédito @break
                                                        @case('cartao_debito') Cartão de Débito @break
                                                        @case('dinheiro') Dinheiro @break
                                                        @case('pix') PIX @break
                                                        @default {{ $venda->forma_pagamento }}
                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{-- Botão de Visualizar/Editar --}}
                                                    <a href="{{ route('vendas.show', $venda->id) }}" class="btn btn-info btn-sm" title="Ver Detalhes/Editar">
                                                        <i class="fa fa-eye"></i> Detalhes
                                                    </a>

                                                    {{-- Botão de Excluir --}}
                                                    <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Tem certeza que deseja excluir esta venda e todos os seus itens/parcelas?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir Venda">
                                                            <i class="fa fa-trash"></i> Excluir
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Adicione o Font Awesome para os ícones, se ainda não tiver --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">