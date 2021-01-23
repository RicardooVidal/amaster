<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Empresa extends Model
{
    protected $table = 'configuracao.empresa';
    protected $fillable = [
        'empresa', 'base', 'cnpj', 'expira', 'ativo'
    ];

    public $timestamps = true;

    public function getSchema()
    {
        $empresa_id = Auth::auth()->id_empresa;
        $empresa = Empresa::find($empresa_id);

        return $empresa->base;
    }
}
