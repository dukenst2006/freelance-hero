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

    public static function completed($limit = null, $user_id = null)
    {
        $user_id = $user_id ?: Auth::user()->id;

        return $work_sessions = WorkSession::where(['user_id' => $user_id])
                    ->whereNotNull('end_time')
                    ->limit($limit)
                    ->orderBy('end_time', 'desc')
                    ->get();
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
            return $sessions = \DB::table('work_sessions')
                ->join('projects', 'work_sessions.project_id', '=', 'projects.id')
                ->select(\DB::raw('SUM(work_sessions.total_hours) as total_time, projects.name'))
                ->where([
                    ['work_sessions.user_id', Auth::user()->id],
                    ['work_sessions.project_id', $project->id],
                    ['work_sessions.start_time', '>=', $starting_point],
                    ['work_sessions.end_time', '<=', $end_point]
                ])->first();
        } else {
            return $sessions = \DB::table('work_sessions')
                ->join('projects', 'work_sessions.project_id', '=', 'projects.id')
                ->select(\DB::raw('SUM(work_sessions.total_hours) as total_time, projects.name'))
                ->where([
                    ['work_sessions.user_id', Auth::user()->id],
                    ['work_sessions.start_time', '>=', $starting_point],
                    ['work_sessions.end_time', '<=', $end_point]
                ])->groupBy('work_sessions.project_id')->get();
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

    public static function getBiMonthlyDate()
    {
        $now = new Carbon();

        if ( $now->day >= 16 ) {
            return $now->day(16)->hour(0)->minute(0)->second(0);
        } else {
            return $now->startOfMonth();
        }
    }

    public function end()
    {
        $this->end_time = new Carbon();
        $start_time_formatted = new Carbon($this->start_time);
        $interval = $this->end_time->diff($start_time_formatted);
        $this->total_hours = $interval->h;

        if ( $interval->i > 45 ) {
            $this->total_hours += 1;
        } else {
            if ( $interval->i % 15 != 0 ) {
                $nearest_quarter = $interval->i - ($interval->i % 15) + 15;
            } else {
                $nearest_quarter = $interval->i;
            }
            $this->total_hours += $nearest_quarter / 60;
        }

        $this->save();
    }
}
