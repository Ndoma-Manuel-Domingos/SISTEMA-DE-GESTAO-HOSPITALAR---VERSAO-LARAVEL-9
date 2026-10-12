<?php

namespace App\Models\CatalogoExame;

use Illuminate\Database\Eloquent\Model;

class CatalogoProduto extends Model
{
    // Especificando o nome da tabela
    protected $table = "catalogo_produtos";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "codigo",
        "nome",
    ];
}
