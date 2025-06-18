<?php

namespace App\Http\Controllers;

use App\Models\Produto; // Certifique-se de importar o Model 'Produto'
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    /**
     * Exibe uma lista de todos os produtos para a visualização web.
     * Mapeado pela Route::resource('produtos', ...) para o GET /produtos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $produtos = Produto::all(); // Busca todos os produtos do banco de dados
        return view('produtos.index', compact('produtos')); // Retorna a view 'produtos/index.blade.php'
    }

    /**
     * Retorna uma lista de produtos em formato JSON, com opção de busca.
     * Mapeado pela Route::get('/api/produtos', ...).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexApi(Request $request)
    {
        $search = $request->query('search');

        $produtos = Produto::select('id', 'nome', 'descricao', 'preco', 'estoque');

        if ($search) {
            $produtos->where('nome', 'like', '%' . $search . '%')
                     ->orWhere('descricao', 'like', '%' . $search . '%');
        }

        $produtos = $produtos->get();

        return response()->json($produtos);
    }

    /**
     * Mostra o formulário para criar um novo produto.
     * Mapeado pela Route::resource('produtos', ...) para o GET /produtos/create.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Armazena um novo produto no banco de dados.
     * Mapeado pela Route::resource('produtos', ...) para o POST /produtos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'preco'     => 'required|numeric|min:0.01',
            'estoque'   => 'required|integer|min:0',
        ]);
        Produto::create($validatedData);
        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Exibe o produto especificado.
     * Mapeado pela Route::resource('produtos', ...) para o GET /produtos/{produto}.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\View\View
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Mostra o formulário para editar o produto especificado.
     * Mapeado pela Route::resource('produtos', ...) para o GET /produtos/{produto}/edit.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\View\View
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Atualiza o produto especificado no banco de dados.
     * Mapeado pela Route::resource('produtos', ...) para o PUT/PATCH /produtos/{produto}.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Produto $produto)
    {
        $validatedData = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
            'preco'     => 'required|numeric|min:0.01',
            'estoque'   => 'required|integer|min:0',
        ]);
        $produto->update($validatedData);
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove o produto especificado do banco de dados.
     * Mapeado pela Route::resource('produtos', ...) para o DELETE /produtos/{produto}.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}