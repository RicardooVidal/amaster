<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\User;
use App\Util\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpresaController extends Controller
{
    // Criar empresa e mudar senha do usuário (PRIMEIRO ACESSO)
    public function store(Request $request)
    {
        try {
            $empresa = Empresa::create([
                'empresa' => Util::toUpperCase($request->razao_social),
                'base' => Util::createSchemaNameByRazaoSocial($request->razao_social),
                'cnpj' => $request->cnpj,
                'expira' => Carbon::now()->addMonth(11)->toDateString(),
                'ativo' => true
            ]);

            $usuario = User::find(Auth::user()->id);

            $usuario->fill([
                'id_empresa' => $empresa->id,
                'nome' => Util::toUpperCase($request->nome),
                'password' => bcrypt($request->password),
            ]);

            $usuario->save();

            $params = [
                'schema' => $empresa->base
            ];

            $response = ApiController::request('/api/empresa', 'POST', json_encode($params));

            return redirect('/');            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
