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

    /**
     * Returns an active session for a given user if one exists; otherwise returns false
     */
    public static function active($user_id = null)
    {
        $user_id = $user_id ?: Auth::user()->id;
        $work_session = WorkSession::where(['end_time' => null, 'user_id' => $user_id])->get();

        return $work_session->isEmpty() ? false : $work_session;
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
