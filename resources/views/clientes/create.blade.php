<x-app-layout>
    <x-slot name="header">

    <H2>TELA 2</H2>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastro de Novo Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Preencha os dados do novo cliente</h3>

                    {{-- Exibir erros de validação --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Ops!</strong>
                            <span class="block sm:inline">Houve alguns problemas com o seu envio.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Mensagem de sucesso (se houver, após um cadastro bem-sucedido) --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Mensagem de erro geral (se houver, de uma exceção por exemplo) --}}
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('clientes.store') }}">
                        @csrf {{-- ESSENCIAL para segurança no Laravel! --}}

                        <div class="mb-4"> {{-- mudado de mb-3 para mb-4 para consistência com Tailwind padrões --}}
                            <label for="razao_social" class="block text-sm font-medium text-gray-700">Razão Social</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="razao_social" name="razao_social" value="{{ old('razao_social') }}" required autofocus>
                            @error('razao_social') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nome_fantasia" class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia') }}">
                            @error('nome_fantasia') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="telefone" name="telefone" value="{{ old('telefone') }}">
                            @error('telefone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logradouro" class="block text-sm font-medium text-gray-700">Logradouro</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="logradouro" name="logradouro" value="{{ old('logradouro') }}">
                            @error('logradouro') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                            <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="numero" name="numero" value="{{ old('numero') }}">
                            @error('numero') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="limite_credito" class="block text-sm font-medium text-gray-700">Limite de Crédito</label>
                            <input type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="limite_credito" name="limite_credito" step="0.01" min="0.00" value="{{ old('limite_credito', '0.00') }}">
                            @error('limite_credito') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mt-3">
                            Cadastrar Cliente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>