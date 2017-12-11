<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isStaff()
	{
		if($this->role == 'admin' || $this->role == 'support')
			return true;

		return false;
	}

	public function profileLink()
	{
		if($this->username != "")
			return "http://socialom.dev/p/" . $this->username;

		return "http://socialom.dev/p/" . $this->id;
	}

	public function isVerified()
	{
		if($this->verified == 'yes')
			return true;

		return false;
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function likes()
	{
		return $this->hasMany(Like::class);
	}
}
