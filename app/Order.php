<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'orderstatus_id' => 'integer',
        'restaurant_charge' => 'float',
        'total' => 'float',
        'payable' => 'float',
        'wallet_amount' => 'float',
        'tip_amount' => 'float',
        'tax_amount' => 'float',
        'coupon_amount' => 'float',
        'sub_total' => 'float',
    ];

    /**
     * @return mixed
     */
    public function customer()   
    {
        return $this->belongsTo('App\Customer');
    }

   /* /**
     * @return mixed
     */
   /* public function orderstatus()
    {
        return $this->belongsTo('App\Orderstatus');
    }*/

    /**
     * @return mixed
     */
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    /* /**
     * @return mixed
     */
   /* public function orderitems()
    {
        return $this->hasMany('App\Orderitem');
    }
     /**
     * @return mixed
     */
    /*public function orderissues()
    {
        return $this->hasMany('App\Orderissue');
    }

     /**
     * @return mixed
     */
    /*public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    /**
     * @return mixed
     */
    /*public function gpstable()
    {
        return $this->hasOne('App\GpsTable');
    }

    /**
     * @return mixed
     */
   /* public function accept_delivery()
    {
        return $this->hasOne('App\AcceptDelivery');
    } */

}
