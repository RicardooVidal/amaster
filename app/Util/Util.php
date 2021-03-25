<?php

namespace App\Util;

use App\Empresa;
use Illuminate\Support\Facades\Auth;

class Util
{

    public static function isJSON($param)
    {
        json_decode($param);
        return (json_last_error()===JSON_ERROR_NONE);
    }

    public static function toUpperCase($string)
    {
        return strtoupper($string);
    }

    public static function toLowerCase($string)
    {
        return strtolower($string);
    }

    public static function convertToMoney($value) : string
    {
        // $value = (float) $value;
        $valueConverted = str_replace(',','.',$value); 
        $valueConverted = number_format($valueConverted, 2);

        return $valueConverted;
    }

    // Converte para reais adicionando vírgula e retirando pontos
    public static function convertToReais($value): string
    {
        $valueConverted = Util::convertToMoney($value);
        $valueConverted = str_replace('.',',',$valueConverted); 

        return $valueConverted;
    }

    // Pegar empresa pelo usuario
    public static function getEmpresa()
    {
        $id_empresa = Auth::user()->id_empresa;
        $empresa = Empresa::find($id_empresa);

        return $empresa->empresa;
    }

    // Pegar usuário e empresa pelo usuario
    public static function getUserAndEmpresa()
    {
        $id_empresa = Auth::user()->id_empresa;
        $empresa = Empresa::find($id_empresa);

        return Auth::user()->nome . ' - ' . $empresa->empresa;
    }

    // Cortar a string se for maior que 55
    public static function stripStringBiggerThan55($string)
    {
        if (strlen($string) > 40) {
            return substr($string, 0, 40) . '...';
        }

        return $string;
    }

    public static function createSchemaNameByRazaoSocial($razao_social)
    {
        $razao_social = Util::toLowerCase($razao_social);
        $schema = str_replace(' ', '', $razao_social) . rand(0, 200);
        $schema = Util::clean($schema);

        return $schema;
    }

    public static function clean($string)
    {
        $toRemove = [
            '/!/' => '',
            '/@/' => '',
            '/#/' => '',
            '/$/' => '',
            '/%/' => '',
            '/¬/' => '',
            '/&/' => '',
            '/\*/' => ''
        ];

        return preg_replace(array_keys($toRemove), array_values($toRemove), $string);

    }
}
