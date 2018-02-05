<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleSchedule extends Model
{
    //
	protected $dates = [
        'created_at',
        'updated_at',
        'start_at',
        'end_at'
    ];
	public function vehicle(){
			return $this->belongsTo('App\Vehicle');
	}
}
