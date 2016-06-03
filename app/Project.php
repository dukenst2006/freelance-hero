<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'start_date',
        'target_end_date',
        'end_date',
        'user_id',
        'organization_id'
    ];

    public function user()
    {
	    return $this->belongsTo('App\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    public function work_sessions()
    {
        return $this->hasMany('App\WorkSession');
    }
}