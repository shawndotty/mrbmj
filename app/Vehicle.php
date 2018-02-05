<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

		public $schedules = [];
    /**
     * Get the orders that the vehicle used for.
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    /**
     * Get the schedules that the vehicle needed.
     */
    public function setSchedules()
    {
    	$orders = $this->orders;
    	if (!empty($orders)) {
    		foreach ($orders as $order) {
    				array_push($this->schedules, $order->schedule);
    		}
    	}
    }

    /**
     * Get the schedules that the driver needed.
     */
    public function vehicleSchedules()
    {
        return $this->hasMany('App\VehicleSchedule');
    }
}
