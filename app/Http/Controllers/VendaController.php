<?php

namespace App\Http\Controllers;

use App\TipoPagamento;
use App\Util\Util;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        $tipo_pagamento = TipoPagamento::all();

        return view('venda.index')->with('tipo_pagamento', $tipo_pagamento);
    }

    public function show($id)
    {
        $data = ApiController::request('/api/venda/' . $id);

        return $data;
    }

    public function tipoPagamento($id)
    {
        $tipo_pagamento = TipoPagamento::find($id);

        return $tipo_pagamento;
    }

    public function viewPendentes(Request $request)
    {
        $tipo_pagamento = TipoPagamento::all();
        $page = $request->page;

        return view('venda.pendente.index')->with('tipo_pagamento', $tipo_pagamento)->with('page', $page);
    }

    public function getAll(Request $request)
    {
        $tipo_pagamento = TipoPagamento::all();
        $page = $request->page;

        return view('venda.view')->with('tipo_pagamento', $tipo_pagamento)->with('page', $page);
    }

    public function listByPage($page)
    {
        if ($page == null || $page == 0) {
            $page = 1;
        }

        $data = ApiController::request('/api/venda?page=' . $page);

        return $data;
    }

    public function getPendentes(Request $request)
    {
        $page = $request->page;
        $data = ApiController::request('/api/venda/pendente?page=' . $page, 'GET');

        return $data;
    }

    public function store(Request $request)
    {
        $params = [
            'tipo_pagamento_id' => $request->input('tipo_pagamento_id'),
            'desconto'          => $request->input('desconto'),
            'troco'             => $request->input('troco'),
            'observacao'        => $request->input('observacao'),
            'valor_total'       => $request->input('valor_total'),
            'produtos'          => json_decode($request->input('produtos'), true),
        ];

        $data = ApiController::request('/api/venda/', 'POST', json_encode($params));

        return $data;
    }

    public function update(Request $request) {
        $params = [
            'tipo_pagamento_id' => $request->input('tipo_pagamento_id'),
            'troco'          => $request->input('troco')
        ];

        $data = ApiController::request('/api/venda/' . $request->id, 'PUT', json_encode($params));

        return $data;
    }

    public function destroy($id)
    {
        $data = ApiController::request('/api/venda/' . $id, 'DELETE');

        return $data;
    }

    public function searchExact(Request $request)
    {
        $field = $request->field;
        $string = rawurlencode($request->string);
        $data = ApiController::request('/api/venda/search_exact?field=' . $field . '&string=' . $string, 'GET');
        return $data;
    }
}
