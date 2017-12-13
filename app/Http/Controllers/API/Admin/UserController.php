<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function updateSuspended(Request $request)
	{
		$user = User::find($request->userId);

		if($request->suspendStatus == "unsuspend"){
			$user->suspended = 'no';
		}elseif($request->suspendStatus == "suspend"){
			$user->suspended = 'yes';
		}else{
			return response()->json(['error' => 'true', 'errorText' => 'Suspended status not recognised'], 400);
		}

		$user->save();

		return response()->json(['error' => 'false'], 200);
	}

	public function updateVerified(Request $request)
	{
		$user = User::find($request->userId);

		if($request->verifiedStatus == "unverify"){
			$user->verified = 'no';
		}elseif($request->verifiedStatus == "verify"){
			$user->verified = 'yes';
		}else{
			return response()->json(['error' => 'true', 'errorText' => 'Verified status not recognised'], 400);
		}

		$user->save();

		return response()->json(['error' => 'false'], 200);
	}

	public function updateRole(Request $request)
	{
		$user = User::find($request->userId);

		$user->role = $request->role;

		$user->save();

		return response()->json(['error' => 'false'], 200);
	}

	public function updateInfo(Request $request)
	{
		$user = User::find($request->user_id);

		if($request->name != "") {
			$user->name = $request->name;
		}

		if($request->email != "") {
			$user->email = $request->email;
		}

		if($request->username != "") {
			$user->username = $request->username;
		}

		$user->save();

		return response()->json(['error' => 'false'], 200);
	}
}
