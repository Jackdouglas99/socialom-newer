<?php

namespace App\Http\Controllers\API\User;

use App\Notifications\NewReportNotification;
use App\Post;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
	/**
	 * Adds a new report
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
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

		$user = User::find($request->user()->id);

		$user->notify(new NewReportNotification($report->id));

		return response()->json(['error' => 'false'], 200);
	}
}
