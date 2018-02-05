<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverSchedule extends Model
{
    //
		protected $guarded = [];

		public function driver(){
			return $this->belongsTo('App\Driver');
		}
		
}
