<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverSchedule extends Model
{
    //
		protected $guarded = [];
		protected $dates = [
        'created_at',
        'updated_at',
        'start_at',
        'end_at'
    ];
		public function driver(){
			return $this->belongsTo('App\Driver');
		}
		
}
