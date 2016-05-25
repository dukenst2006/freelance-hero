<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSession extends Model
{
    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
