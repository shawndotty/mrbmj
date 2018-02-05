<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /**
     * Get the orders that the driver works for.
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    /**
     * Get the schedules that the driver needed.
     */
    public function driverSchedules()
    {
        return $this->hasMany('App\DriverSchedule');
    }
}
