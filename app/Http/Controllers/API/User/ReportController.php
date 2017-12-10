<?php

namespace App\Http\Controllers\API\User;

use App\Post;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function newReport(Request $request)
	{
		$post = Post::find($request->postID);
		$report = new Report();
		$report->reporter_user_id = $request->user()->id;
		$report->reportee_user_id = $post->user_id;
		$report->type = 'post';
		$report->content_id = $request->postID;
		$report->reason = $request->reason;
		$report->save();

		return response()->json(['error' => 'false'], 200);
	}
}
