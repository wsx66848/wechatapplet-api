<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ModelException;

class BaseModel extends Model
{
    //
    public function resolveRouteBinding($value) {
        if($model = $this->find($value)) {
            return $model;
        }
        throw new ModelException('model not found', 404);
    }
}
