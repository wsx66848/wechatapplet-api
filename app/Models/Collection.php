<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends BaseModel
{
    //
    protected $table = 'user_collection';

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function collectionable() {
        return $this->morphTo();
    }

    public static function collectionModel($model, $name, $user) {
        $model_type = strtolower(class_basename(get_class($model)));
        $collection = new static;
        $collection->collectionable_type = $model_type;
        $collection->collectionable_id = $model->getKey();
        $collection->name = $name;
        $collection->user_id = $user->getKey();
        $collection->save();
        return $collection; 

    }
}
