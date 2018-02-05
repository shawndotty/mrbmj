<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'pickup_at',
        'dropoff_at'
    ];
		
    /**
     * Get the client that owns the order.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * Get the invoices for the order.
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }  

    /**
     * Get the drivers that take this order.
     */
    public function drivers()
    {
        return $this->belongsToMany('App\Driver');
    }

    /**
     * Get the guides that take this order.
     */
    public function guides()
    {
        return $this->belongsToMany('App\Guide');
    }

    /**
     * Get the vehicles that this order use.
     */
    public function vehicles()
    {
        return $this->belongsToMany('App\Vehicle');
    }

}
