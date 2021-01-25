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
}