<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class articles extends Model
{
    //
    public function category(){
        return $this->belongsTo('App\category','category_id', 'id');
    }
    public function published_by(){
        return $this->belongsTo('App\User','published_by', 'id');
    }
}
