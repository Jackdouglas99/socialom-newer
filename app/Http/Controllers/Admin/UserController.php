<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function users()
	{
		$users = User::orderBy('created_at', 'asc')->paginate(15);
		return view('admin.users')->with(['users' => $users]);
	}

	public function user($user_id)
	{
		if($user_id == Auth::id())
			return redirect()->route('admin.users')->with('error', 'You cant view your own profile.');

		$user = User::find($user_id);
		return view('admin.user')->with(['user' => $user]);
	}
}
