<?php

namespace App;

use Auth;
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

    public function complete()
    {
        if ( $this->user_id === Auth::user()->id ) {
            $this->status = 'Completed';
            $this->end_date = date('Y-m-d');
            $this->save();
            return true;
        } else {
            return false;
        }
    }

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
        return $this->hasMany('App\WorkSession')->orderBy('end_time', 'desc');
    }
}