<?php

namespace App\Http\Controllers\Auth;

use App\Empresa;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $user = User::where([['id','=','1'],['username','=', 'admin']])->first();
        if (!$user)
        {
            Empresa::create([
                'empresa' => 'ADEGA TESTE',
                'base' => 'ricardovidal',
                'cnpj' => '36320890000166',
                'expira' => '2021-12-31',
                'ativo' => true
            ]);

            User::create([
                'id_empresa' => 1,
                'username' => 'admin',
                'nome' => 'Ricardo Vidal',
                //'email' => $data['email'],
                'password' => bcrypt('22361141'),
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = User::find(Auth::user()->id);

            $new_token = User::generateToken();

            $user->fill([
                'api_token' => $new_token
            ]);

            try {
                $user->save();
            } catch (Exception $e) {
                throw new Exception('Não foi possível gerar o token de acesso');
            }
            
            return redirect()->intended();
        }

        return view('auth.login')->with('msg', 'Usuário ou senha inválidos!');
    }
}
