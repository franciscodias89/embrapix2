<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');  
    }

   
}
