<?php

namespace App\Exceptions;

use Exception;

class TokenException extends Exception
{
    //
    public function report() {

    }

    public function render($request) {
        return response()->json(['err_code' => $this->getCode(), 'err_msg' => $this->getMessage()], 401);
    }
}
