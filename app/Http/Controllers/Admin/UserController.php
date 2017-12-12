<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function users()
	{
		$users = User::orderBy('created_at', 'asc')->paginate(15);
		return view('admin.users')->with(['users' => $users]);
	}
}
