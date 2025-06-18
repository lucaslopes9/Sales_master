<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos via atribuição em massa
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'logradouro',
        'numero',
        'limite_credito',
    ];

    // Se sua tabela não for 'clientes' (o Laravel infere do nome do modelo no plural),
    // você pode definir explicitamente:
    // protected $table = 'nome_da_sua_tabela';
}