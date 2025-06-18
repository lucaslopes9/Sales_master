<?php

namespace App\Http\Controllers;

use App\Models\Venda; // Import the Venda model
use App\Models\Cliente; // Import the Cliente model
use App\Models\Produto; // Import the Produto model (needed for stock management)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // For database transactions
use Illuminate\Validation\ValidationException; // For validation errors

class VendaController extends Controller
{
    /**
     * Display a listing of the sales.
     * This method will fetch and display all sales.
     */
    public function index()
    {
        // Fetch all sales, ordered by the most recent,
        // eager-loading the 'cliente' relationship to display client names.
        $vendas = Venda::with('cliente')->latest()->get();

        // Return the 'vendas.index' view, passing the sales data to it.
        return view('vendas.index', compact('vendas'));
    }

    /**
     * Show the form for creating a new resource.
     * In your project, the "create sale" form is likely on your dashboard.
     * So, this method might not be strictly necessary if your dashboard handles it.
     */
    public function create()
    {
        // If you had a dedicated form page for creating a sale, it would be rendered here.
        // For example: return view('vendas.create');
        // You would likely pass client and product data to this view.
    }

    /**
     * Store a newly created sale in storage.
     * This method handles the POST request from your sale registration form.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data.
        try {
            $request->validate([
                'cliente_id' => 'nullable|exists:clientes,id', // Can be null for walk-in clients
                'forma_pagamento' => 'required|string|max:50',
                'total_venda' => 'required|numeric|min:0', // Ensure total_venda is sent from frontend
                'itens' => 'required|array|min:1', // Must have at least one item
                'itens.*.produto_id' => 'required|exists:produtos,id',
                'itens.*.quantidade' => 'required|integer|min:1',
                'itens.*.valor_unitario' => 'required|numeric|min:0.01',
                'parcelas' => 'nullable|array', // Optional for credit card sales
                'parcelas.*.valor' => 'required_with:parcelas|numeric|min:0.01',
                'parcelas.*.data_vencimento' => 'required_with:parcelas|date',
            ]);
        } catch (ValidationException $e) {
            // If validation fails, redirect back with errors and input.
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Erro de validação: Verifique os dados inseridos.');
        }

        // 2. Start a database transaction.
        // This ensures that if any part of the sale (main sale, items, parcels) fails,
        // everything is rolled back, preventing inconsistent data.
        DB::beginTransaction();

        try {
            // 3. Create the main sale record.
            $venda = Venda::create([
                'cliente_id' => $request->cliente_id,
                'total_venda' => $request->total_venda,
                'forma_pagamento' => $request->forma_pagamento,
                'user_id' => auth()->id(), // Associate the sale with the authenticated user
            ]);

            // 4. Save the sale items and update product stock.
            foreach ($request->itens as $itemData) {
                $produto = Produto::find($itemData['produto_id']);

                // Check if product exists and if there's enough stock
                if (!$produto || $produto->estoque < $itemData['quantidade']) {
                    DB::rollBack(); // Rollback the transaction
                    return redirect()->back()->withInput()->with('error', 'Estoque insuficiente para o produto: ' . ($produto->nome ?? 'ID: ' . $itemData['produto_id']));
                }

                // Decrement the product stock
                $produto->decrement('estoque', $itemData['quantidade']);

                // Create the sale item associated with the sale
                $venda->itens()->create([
                    'produto_id' => $itemData['produto_id'],
                    'quantidade' => $itemData['quantidade'],
                    'valor_unitario' => $itemData['valor_unitario'],
                ]);
            }

            // 5. Save the parcels if the payment method is 'cartao_credito'.
            if ($request->forma_pagamento === 'cartao_credito' && $request->has('parcelas')) {
                // Optional: Validate that the sum of parcels doesn't exceed the total sale amount
                $totalParcelas = collect($request->parcelas)->sum('valor');
                if (round($totalParcelas, 2) > round($venda->total_venda, 2)) {
                    DB::rollBack();
                    return redirect()->back()->withInput()->with('error', 'A soma das parcelas (R$ ' . number_format($totalParcelas, 2, ',', '.') . ') não pode ultrapassar o valor total da venda (R$ ' . number_format($venda->total_venda, 2, ',', '.') . ').');
                }

                foreach ($request->parcelas as $parcelaData) {
                    $venda->parcelas()->create([
                        'valor' => $parcelaData['valor'],
                        'data_vencimento' => $parcelaData['data_vencimento'],
                        'status' => 'pendente', // Default status for new parcels
                    ]);
                }
            }

            // 6. Commit the transaction if all operations were successful.
            DB::commit();

            // 7. Redirect to the sales list with a success message.
            return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');

        } catch (\Exception $e) {
            // If any other exception occurs, rollback the transaction and show an error.
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao registrar a venda: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified sale.
     * This method fetches and displays the details of a single sale.
     */
    public function show(Venda $venda) // Using Route Model Binding
    {
        // Eager-load the related client, items (with their products), and parcels.
        $venda->load('cliente', 'itens.produto', 'parcelas');

        // Return the 'vendas.show' view, passing the specific sale data to it.
        return view('vendas.show', compact('venda'));
    }

    /**
     * Show the form for editing the specified sale.
     * This method is generally used to populate an edit form with existing data.
     */
    public function edit(string $id)
    {
        // Logic to retrieve the sale and pass it to an edit view
        // return view('vendas.edit', compact('venda'));
    }

    /**
     * Update the specified sale in storage.
     * This method handles the PUT/PATCH request to update an existing sale.
     * This logic can be quite complex due to nested items and parcels.
     */
    public function update(Request $request, string $id)
    {
        // You will implement the update logic here. This often involves:
        // 1. Validating the request data.
        // 2. Finding the Venda by $id.
        // 3. Updating the Venda's main attributes.
        // 4. Handling updates/deletions/additions of associated ItemVenda records.
        // 5. Handling updates/deletions/additions of associated Parcela records.
        // This typically also involves database transactions.
        // For example:
        // $venda = Venda::findOrFail($id);
        // $venda->update($request->all());
        // return redirect()->route('vendas.index')->with('success', 'Venda atualizada com sucesso!');
    }

    /**
     * Remove the specified sale from storage.
     * This method handles the DELETE request to remove a sale.
     */
    public function destroy(Venda $venda) // Using Route Model Binding
    {
        // Start a database transaction for the deletion process.
        DB::beginTransaction();

        try {
            // Optional: Restore product stock.
            // Decide if you want to increment the stock of products sold in this sale.
            // This depends on your business logic.
            foreach ($venda->itens as $item) {
                $produto = Produto::find($item->produto_id);
                if ($produto) {
                    $produto->increment('estoque', $item->quantidade);
                }
            }

            // Delete associated items and parcels first.
            // If you have `onDelete('cascade')` set up in your migrations for foreign keys,
            // these lines might not be strictly necessary as the cascade will handle it.
            $venda->itens()->delete();
            $venda->parcelas()->delete();

            // Delete the main sale record.
            $venda->delete();

            // Commit the transaction.
            DB::commit();

            // Redirect with a success message.
            return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');

        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction and redirect with an error message.
            DB::rollBack();
            return redirect()->route('vendas.index')->with('error', 'Erro ao excluir a venda: ' . $e->getMessage());
        }
    }
}