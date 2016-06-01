<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class WorkSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'total_time',
        'user_id',
        'project_id'
    ];

    public static function active()
    {
        return WorkSession::where(['end_time' => null, 'user_id' => Auth::user()->id])->get();
    }

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
