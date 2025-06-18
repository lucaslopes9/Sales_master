<?php

namespace App\Http\Controllers;

use App\Models\Cliente; // Certifique-se de que esta linha está presente e correta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Boa prática para depuração, se precisar

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Busca todos os clientes do banco de dados
        $clientes = Cliente::all();
        // Retorna a view 'clientes.index' e passa a coleção de clientes
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Este método simplesmente retorna a view com o formulário de cadastro.
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Log::info('Tentativa de cadastro de cliente.', $request->all()); // Descomente para depurar

        // 1. Validação dos dados do formulário
        try {
            $validatedData = $request->validate([
                'razao_social'    => 'required|string|max:255',
                'nome_fantasia'   => 'nullable|string|max:255',
                'email'           => 'required|email|unique:clientes,email|max:255',
                'telefone'        => 'nullable|string|max:20',
                'logradouro'      => 'nullable|string|max:255',
                'numero'          => 'nullable|string|max:100',
                'limite_credito'  => 'nullable|numeric|min:0', // Validar como numérico
            ]);
            // Log::info('Dados validados com sucesso.', $validatedData); // Descomente para depurar
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log::error('Erro de validação ao cadastrar cliente:', ['errors' => $e->errors(), 'input' => $request->all()]); // Descomente para depurar
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // 2. Criação do cliente no banco de dados
        try {
            Cliente::create($validatedData);
            // Log::info('Cliente cadastrado com sucesso!'); // Descomente para depurar
        } catch (\Exception $e) {
            // Log::error('Erro ao salvar cliente no banco de dados:', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]); // Descomente para depurar
            return redirect()->back()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage())->withInput();
        }

        // 3. Redirecionamento após o cadastro (com mensagem de sucesso)
        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\View\View
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\View\View
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Cliente $cliente)
    {
        // 1. Validação dos dados para atualização
        $validatedData = $request->validate([
            'razao_social'    => 'required|string|max:255',
            'nome_fantasia'   => 'nullable|string|max:255',
            'email'           => 'required|email|unique:clientes,email,' . $cliente->id, // Ignora o próprio ID do cliente na validação unique
            'telefone'        => 'nullable|string|max:20',
            'logradouro'      => 'nullable|string|max:255',
            'numero'          => 'nullable|string|max:100',
            'limite_credito'  => 'nullable|numeric|min:0',
        ]);

        // 2. Atualização do cliente
        $cliente->update($validatedData);

        // 3. Redirecionamento com mensagem de sucesso
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Retorna uma lista de clientes para consumo via API/AJAX.
     * Usado, por exemplo, em modais de seleção ou campos de busca.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getApiClientes(Request $request)
    {
        $search = $request->query('search');

        $clientes = Cliente::select(
            'id',
            'razao_social',
            'nome_fantasia',
            'logradouro',
            'numero',
            'limite_credito'
        );

        if ($search) {
            $clientes->where('razao_social', 'like', '%' . $search . '%')
                     ->orWhere('nome_fantasia', 'like', '%' . $search . '%');
        }

        $clientes = $clientes->get();

        return response()->json($clientes);
    }
}