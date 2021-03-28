<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Middleware\CheckApi;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->group(function() {
    Route::middleware([CheckApi::class])->group(function () {
        Route::post('/empresa', 'EmpresaController@store')->name('empresa.create');
        Route::get('/empresa/check', 'EmpresaController@check')->name('empresa.check');
        Route::get('/', 'HomeController@index')->name('home');

        Route::get('/get-token', function() {
            return response()
            ->json(
                [
                    'api_token' => Auth::user()->api_token,
                ],
                200
            );
        });
    
        Route::prefix('/error')->group(function () {
            Route::get('/list/{page}', 'ErrorController@index');
        });
    
        Route::prefix('/produto')->group(function () {
            Route::get('/list/{page}', 'ProdutoController@index');
            Route::get('/byPage/{page}', 'ProdutoController@listByPage'); // Returns JSON
            Route::get('/search', 'ProdutoController@searchByField');
            Route::get('/search_exact', 'ProdutoController@searchExact');
            Route::get('/{id}', 'ProdutoController@show');
            Route::post('', 'ProdutoController@store');
            Route::put('/{id}', 'ProdutoController@update');
            Route::delete('/{id}', 'ProdutoController@destroy');
        });
    
        Route::prefix('/venda')->group(function () {
            Route::get('/', 'VendaController@index');
            Route::post('', 'VendaController@store');
            Route::put('/{id}', 'VendaController@update');
            Route::get('/search_exact', 'VendaController@searchExact');
            Route::get('/list/{page}', 'VendaController@getAll');
            Route::get('/list/byPage/{page}', 'VendaController@listByPage');
            Route::get('/pendente/{page}', 'VendaController@getPendentes');
            Route::get('/pendente/list/{page}', 'VendaController@viewPendentes');
            Route::get('/{id}', 'VendaController@show');
            Route::get('/tipo_pagamento/{id}', 'VendaController@tipoPagamento');
            Route::delete('/{id}','VendaController@destroy');
        });
    
        Route::prefix('/relatorio')->group(function () {
            Route::get('/', 'RelatorioController@index');
            Route::get('/periodo', 'RelatorioController@periodo');
            Route::get('/periodo/emitir', 'RelatorioController@byPeriodo');
    
            Route::get('/categoria', 'RelatorioController@categoria');
            Route::get('/categoria/emitir', 'RelatorioController@byCategoria');
    
            Route::get('/tipo_pagamento', 'RelatorioController@tipo_pagamento');
            Route::get('/tipo_pagamento/emitir', 'RelatorioController@byTipoPagamento');
    
            Route::get('/mais_vendido', 'RelatorioController@maisVendido');
        });
    });    
});

Auth::routes();

Route::post('login', '\App\Http\Controllers\Auth\LoginController@authenticate');