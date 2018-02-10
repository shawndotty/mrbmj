<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuideSchedule extends Model
{
    //
	protected $guarded = [];
	protected $dates = [
      'created_at',
      'updated_at',
      'start_at',
      'end_at'
  ];
	public function guide(){
			return $this->belongsTo('App\Driver');
	}
}
