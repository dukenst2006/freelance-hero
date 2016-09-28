<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

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
        'total_hours',
        'user_id',
        'project_id'
    ];

    /**
     * Returns an active session for a given user if one exists; otherwise returns false
     */
    public static function active($user_id = null)
    {
        $user_id = $user_id ?: Auth::user()->id;
        $work_session = WorkSession::where(['end_time' => null, 'user_id' => $user_id])->first();

        return $work_session ?: false;
    }

    public static function completed($user_id = null)
    {
        $user_id = $user_id ?: Auth::user()->id;
        $work_sessions = WorkSession::where(['user_id' => $user_id])->whereNotNull('end_time')->get();

        return $work_sessions;
    }

    public static function recent($number = 5)
    {
        return WorkSession::where(['user_id' => Auth::user()->id])->orderBy('end_time', 'desc')->limit($number)->get();
    }

    public static function summary(Project $project = null, $start = null, $end = null)
    {
        $now = new Carbon();
        $starting_point = $start ?: $now->startOfWeek();
        $end_point = $end ?: new Carbon();

        if ( $project ) {
            return $sessions = WorkSession::select(\DB::raw('SUM(total_hours) as total_time'))->where([
                ['user_id', Auth::user()->id],
                ['project_id', $project->id],
                ['start_time', '>=', $starting_point],
                ['end_time', '<=', $end_point]
            ])->first();
        } else {
            return $sessions = WorkSession::select(\DB::raw('project_id, SUM(total_hours) as total_time'))->where([
                ['user_id', Auth::user()->id],
                ['project_id', $project->id],
                ['start_time', '>=', $starting_point],
                ['end_time', '<=', $end_point]
            ])->groupBy('project_id')->first();
        }
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
