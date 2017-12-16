<?php

namespace App\Http\Controllers\API\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function updatePost(Request $request)
	{
		$post = Post::find($request->post_id);

		$post->body = $request->body;
		$post->visibility = $request->visibility;

		$post->save();

		return response()->json(['error' => false], 200);
	}


}
