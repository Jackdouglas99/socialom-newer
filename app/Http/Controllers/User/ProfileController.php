<?php

namespace App\Http\Controllers\User;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
	/**
	 * Returns a profile with all the user's posts to fill the news feed
	 *
	 * @param $user
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    public function getProfile($user)
	{
		$userInfo = User::where('id', $user)->orWhere('username', $user)->first();
		if (!$userInfo->count())
			return response()->json(['error' => true], 404);
		$posts = Post::where('user_id', $userInfo->id)->orderBy('created_at', 'desc')->paginate(20);
		return view('user.profile')->with(['user' => $userInfo, 'posts' => $posts]);
	}
}
