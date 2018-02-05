<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
		protected $fillable = ['name'];
		
		/**
     * Get the orders for the client.
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }    

		/**
     * Get the invoices for the client.
     */
    public function invoices()
    {
        return $this->hasManyThrough('App\Invoice', 'App\Order');
    }    
}
