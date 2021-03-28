<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        if (Auth::user()->id_empresa == 0) {
            return view('home.first-access');
        }

        $licenca = EmpresaController::check();

        if ($licenca['status'] == 401) {
            abort(401, $licenca['msg']);
        }

        return view('home.index');
    }
}
