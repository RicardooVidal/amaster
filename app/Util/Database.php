<?php

namespace App\Util;

use App\Empresa;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Database {
    public static function changeSchema($token)
    {
        if (Auth::user()->id_empresa != 0) {
            $schema = Database::getSchemaByToken($token);

            config(['database.connections.' . env('DB_CONNECTION') . '.schema' => $schema]);
    
            \DB::reconnect(env('DB_CONNECTION'));
        }
    }

    public static function getSchemaByToken($token)
    {
        $user =  User::where('api_token', $token)->first();
        $empresa = Empresa::where('id', $user->id_empresa)->first();

        return $empresa->base;
    }

    public static function getSchemaByConfig()
    {
        $schema = config('database.connections.' . env('DB_CONNECTION') . '.schema');

        return $schema;
    }
}