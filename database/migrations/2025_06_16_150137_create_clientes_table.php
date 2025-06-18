<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         //colunas da tabela clientes do banco de dados
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // Coluna de ID primária auto-incrementável
            $table->string('razao_social', 255)->unique(); // Ex: "Empresa de Vendas Ltda."
            $table->string('nome_fantasia', 255)->nullable(); // Ex: "Venda Tudo"
            $table->string('logradouro', 255)->nullable(); // Ex: "Rua das Flores"
            $table->string('numero', 50)->nullable(); // Ex: "123" ou "S/N"
            $table->decimal('limite_credito', 10, 2)->default(0.00); // Limite de crédito do cliente
            $table->timestamps(); // Colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
