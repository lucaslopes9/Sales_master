<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <h1>Formulário de Cadastro de Produto</h1>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('produtos.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Preço</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" value="{{ old('price', 0.01) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Estoque</label>
                                <input type="number" class="form-control" id="stock" name="stock" min="0" value="{{ old('stock', 0) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar Produto</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar ao Painel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>