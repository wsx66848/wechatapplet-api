<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Model;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = null) {
        if ($data instanceof Collection) {
            $data = $data->map(function ($d) {
                if ($d instanceof Model) {
                    return $d->toArray();
                }
                return $d;
            })->all();
        } else if ($data instanceof Model) {
            $data = $data->toArray();
        } else if (is_array($data)) {
            unset ($data['success']);
        }
        return [
            'success' => true,
            'data' => $data
        ];
    }

    public function error($mixed = '操作失败') {
        if (is_string($mixed)) {
            return [
                'success' => false,
                'message' => $mixed
            ];
        }
        return [
            'success' => false,
            'errors' => $mixed
        ];
    }
}
