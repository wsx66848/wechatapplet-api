<?php

namespace App\Exceptions;

use Exception;

class ModelException extends Exception
{
    //
    public function report() {

    }

    public function render($request) {
        $code = $this->getCode();
        $message = $this->getMessage();
        return response()->json(['success' => false, 'errors' => compact('code', 'message')], 200);
    }
}
