<?php

namespace App\Http\Controllers\API\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function saveProfile(Request $request)
	{
		$user = User::where('id', $request->user()->id)->first();

		if($request->username != "") {
			if (User::where('username', $request->username)->count())
				return response()->json(['error' => true, 'errorType' => 'Username Exists'], 400);

			$user->username = $request->username;
		}

		if($request->email != "") {
			if (User::where('email', $request->email)->count())
				return response()->json(['error' => true, 'errorType' => 'Email Exists'], 400);

			$user->email = $request->email;
		}

		if($request->name != "")
			$user->name = $request->name;

		$user->save();

		return response()->json(['error' => false], 200);
	}

	public function savePassword(Request $request)
	{
		$user = User::where('id', $request->user()->id)->first();

		if(Hash::check($request->current_password, $user->password))
		{
			if($request->password === $request->password_confirmation)
			{
				$user->password = Hash::make($request->password);
				$user->save();
				return response()->json(['error' => false], 200);
			}
		}else{
			return response()->json(['error' => 'true', 'errorType' => 'Current Password Incorrect'], 409);
		}
	}

	public function savePrivacy(Request $request)
	{

	}
}
