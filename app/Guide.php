<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
   /**
     * Get the orders that the guide works for.
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    /**
     * Get the schedules that the guide needed.
     */
    public function guideSchedules()
    {
        return $this->hasMany('App\GuideSchedule');
    }
}
