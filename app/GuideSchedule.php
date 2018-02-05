<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuideSchedule extends Model
{
    //
	public function guide(){
			return $this->belongsTo('App\Driver');
	}
}
