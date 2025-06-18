<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Produto extends Model
{
    use HasFactory;
    // Remova ou garanta que não existe: protected $table = 'products';

    protected $fillable = [
        'name',      // << EM PORTUGUÊS
        'description', // << EM PORTUGUÊS
        'price',     // << EM PORTUGUÊS
        'stock',   // << EM PORTUGUÊS
    ];
}