<?php

namespace App\Util;

use Barryvdh\Snappy\Facades\SnappyPdf;

class PDF
{
    public static function viewToPDF($view, $data)
    {
        $filename = Pdf::getFileName();
        $pdf = SnappyPdf::loadView($view, array('data' => $data));
        return $pdf->download($filename);
    }

    public static function getFileName() : string
    {
        return preg_replace('/\./', '', uniqid(rand(), true)) . '.pdf';
    }
}
