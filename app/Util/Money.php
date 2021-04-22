<?php 

namespace App\Util;

class Money {

    // To elasticsearch
    public static function parseInt($value) 
    {
        $value = str_replace('.','', $value);
        $value = intval($value);

        return $value; 
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
        $value = $value / 100;
        $valueConverted = number_format($value, 2);
        $valueConverted = str_replace('.',',', $valueConverted); 

        return $valueConverted;
    }

    /** Calcula margem de lucro
    * @params $preco_custo
    * @params $preco_venda
    * @returns integer
    */
    public static function getMargemLucro($preco_custo, $preco_venda)
    {
        $lucro = $preco_venda - $preco_custo;
        $margem = $lucro / $preco_venda;
        return round($margem * 100);
    }

    /**  Calcula valor de lucro
    * @params $preco_custo
    * @params $preco_venda
    * @returns integer
    */
    public static function getValorLucro($preco_custo, $preco_venda)
    {
        return $preco_venda - $preco_custo;
    }
}