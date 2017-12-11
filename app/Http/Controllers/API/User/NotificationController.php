<?php

namespace App\Http\Controllers\API\User;

use App\Notifications\PostLiked;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

	/**
	 * Marks all the notifications as read for a user
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function markAsRead(Request $request)
	{
		$user = User::find($request->user()->id);

		$user->unreadNotifications()->update(['read_at' => Carbon::now()]);

		return response()->json(['error' => false], 200);
	}


	/*public function test($user_id, $post_id)
	{
		$user = User::find($user_id);
		$post = Post::find($post_id);

		$user->notify(new PostLiked($post, Auth::user()));

		return response()->json(['error' => false], 200);
	}*/
}
