<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\TipoPagamento;
use App\Util\PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorio.index');
    }

    public function categoria()
    {
        $categorias = Categoria::all();
        return view('relatorio.categoria')->with('categorias', $categorias);
    }

    public function byCategoria(Request $request)
    {
        $data = ApiController::request('/api/relatorio/categoria?categoria_id=' . $request->categoria_id . '&data_inicial=' . $request->data_inicial . '&data_final=' . $request->data_final, 'GET');

        $categoria = Categoria::find($request->categoria_id);

        $data['categoria'] = $categoria->descricao;
        $data['data_requisicao'] = Carbon::now()->format('d/m/Y');
        $data['data_inicial'] = Carbon::parse($request->data_inicial)->format('d/m/Y');
        $data['data_final'] = Carbon::parse($request->data_final)->format('d/m/Y');

        return PDF::viewToPDF('relatorio.maker.categoria', $data);
        // return view('relatorio.maker.categoria')->with('data', $data);
    }

    public function periodo()
    {
        return view('relatorio.periodo');
    }

    public function byPeriodo(Request $request)
    {
        $data = ApiController::request('/api/relatorio/periodo?data_inicial=' . $request->data_inicial . '&data_final=' . $request->data_final, 'GET');

        $data['data_requisicao'] = Carbon::now()->format('d/m/Y');
        $data['data_inicial'] = Carbon::parse($request->data_inicial)->format('d/m/Y');
        $data['data_final'] = Carbon::parse($request->data_final)->format('d/m/Y');

        return PDF::viewToPDF('relatorio.maker.periodo', $data);
        // return view('relatorio.maker.periodo')->with('data', $data);
    }

    public function tipo_pagamento()
    {
        $tipo_pagamento = TipoPagamento::all();
        return view('relatorio.tipo_pagamento')->with('tipo_pagamento', $tipo_pagamento);
    }

    public function byTipoPagamento(Request $request)
    {
        $tipo_pagamento = TipoPagamento::find($request->tipo_pagamento_id);

        $data = ApiController::request('/api/relatorio/tipo_pagamento?tipo_pagamento='. rawurlencode($tipo_pagamento->descricao) .'&data_inicial=' . $request->data_inicial . '&data_final=' . $request->data_final, 'GET');

        $data['tipo_pagamento'] = $tipo_pagamento->descricao;
        $data['data_requisicao'] = Carbon::now()->format('d/m/Y');
        $data['data_inicial'] = Carbon::parse($request->data_inicial)->format('d/m/Y');
        $data['data_final'] = Carbon::parse($request->data_final)->format('d/m/Y');

        return PDF::viewToPDF('relatorio.maker.tipo_pagamento', $data);
        // return view('relatorio.maker.tipo_pagamento')->with('data', $data);
    }

    public function maisVendido(Request $request) 
    {
        $data = ApiController::request('/api/relatorio/mais_vendido?data_inicial=' . $request->data_inicial . '&data_final=' . $request->data_final, 'GET');

        return $data;
    }
}
