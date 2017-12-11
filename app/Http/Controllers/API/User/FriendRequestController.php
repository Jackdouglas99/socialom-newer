<?php

namespace App\Http\Controllers\API\User;

use App\FriendRequest;
use App\Notifications\FriendRequestAcceptedNotification;
use App\Notifications\FriendRequestNotification;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendRequestController extends Controller
{
	/**
	 * Sends a friend request
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function sendFriendRequest(Request $request)
	{
		$friendRequest = new FriendRequest();
		$friendRequest->sender_user_id = $request->user()->id;
		$friendRequest->recipient_user_id = $request->userId;
		$friendRequest->save();

		$user = User::where('id', $request->userId)->first();

		$user->notify(new FriendRequestNotification($request->user()->id, $user->id));

		return response()->json(['error' => false], 200);
	}

	/**
	 * Updates a friend request
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateFriendRequest(Request $request)
	{
		$friendRequest = FriendRequest::find($request->friendRequestId);

		$friendRequest->status = $request->friendRequestStatus;
		$friendRequest->save();

		$user = User::find($friendRequest->sender_user_id);

		$user->notify(new FriendRequestAcceptedNotification($friendRequest->recipient_user_id, $user->id));

		return response()->json(['error' => false], 200);
	}
}
