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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Vendedor responsável
            $table->string('nome_cliente')->nullable(); // Cliente (opcional)
            // Ou, se tiver uma tabela de clientes: $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null');
            $table->string('forma_pagamento');
            $table->decimal('valor_total', 10, 2); // 10 dígitos no total, 2 após a vírgula
            $table->timestamp('data_venda')->useCurrent();
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};