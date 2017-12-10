<?php

namespace App\Http\Controllers\User;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
	{
		$posts = Post::orderBy('created_at', 'desc')->paginate(20);
		return view('user.index')->with(['posts' => $posts]);
	}
}
