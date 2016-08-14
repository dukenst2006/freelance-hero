<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'last_logged_in'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activate()
    {
        $this->active = true;
        $this->save();
    }

    public function deactivate()
    {
        $this->active = false;
        $this->save();
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function work_sessions()
    {
        return $this->hasMany('App\WorkSession');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization');
    }

    public function isAdmin(User $user = null)
    {
        $user = $user ?: Auth::user();
        if ($user->role === "Admin") {
            return true;
        }

        return false;
    }
}
