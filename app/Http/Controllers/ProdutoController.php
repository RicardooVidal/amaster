<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Categoria;
use App\Util\Util;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index($page)
    {
        if ($page == null || $page == 0) {
            $page = 1;
        }

        $categorias = Categoria::all();

        return view('produto.index')->with('page', $page)->with('categorias', $categorias);
        // return view('produto.index')->with('data', $response);
    }

    public function listByPage($page)
    {
        if ($page == null || $page == 0) {
            $page = 1;
        }

        $data = ApiController::request('/api/produto?page=' . $page);

        return $data;
        // return view('produto.index')->with('data', $response);
    }

    public function show($id)
    {
        $data = ApiController::request('/api/produto/'. $id);

        // return view('produto.index', compact('data'));
        return $data;
        // return view('produto.index')->with('data', $response);
    }

    public function store(Request $request)
    {
        $params = [
            'codigo_barra'       => $request->input('codigo_barra'),
            'descricao'          => Util::toUpperCase($request->input('descricao')),
            'unidade_medida'     => $request->input('unidade_medida'),
            'categoria_id'       => $request->input('categoria_id'),
            'ativo'              => $request->input('ativo'),
            'quantidade_estoque' => $request->input('quantidade_estoque'),
            'preco_custo'        => $request->input('preco_custo'),
            'preco_venda'        => $request->input('preco_venda'),
        ];

        $data = ApiController::request('/api/produto/', 'POST', json_encode($params));
        
        return $data;
    }

    public function update(Request $request)
    {
        $params = [
            'id'                 => $request->input('id'),
            'codigo_barra'       => $request->input('codigo_barra'),
            'descricao'          => Util::toUpperCase($request->input('descricao')),
            'unidade_medida'     => $request->input('unidade_medida'),
            'categoria_id'       => $request->input('categoria_id'),
            'ativo'              => $request->input('ativo'),
            'quantidade_estoque' => $request->input('quantidade_estoque'),
            'preco_custo'        => $request->input('preco_custo'),
            'preco_venda'        => $request->input('preco_venda'),
        ];

        $data = ApiController::request('/api/produto/' . $request->id, 'PUT', json_encode($params));

        return $data;
    }

    public function destroy($id)
    {
        $data = ApiController::request('/api/produto/' . $id, 'DELETE');

        return $data;
    }

    public function searchByField(Request $request)
    {
        $field = $request->field;
        $string = $request->string;
        $data = ApiController::request('/api/produto/search?field=' . $field . '&string=' . $string, 'GET');
        return $data;
    }

    public function searchExact(Request $request)
    {
        $field = $request->field;
        $string = rawurlencode($request->string);
        $data = ApiController::request('/api/produto/search_exact?field=' . $field . '&string=' . $string, 'GET');
        return $data;
    }
}
