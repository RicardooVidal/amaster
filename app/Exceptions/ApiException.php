<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function register()
    {
        // ...
    }

    public function render()
    {
        return response()->view('errors.api', [], 500);
    }
}