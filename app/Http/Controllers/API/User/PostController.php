<?php

namespace App\Http\Controllers\API\User;

use App\Like;
use App\Notifications\PostLiked;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
	/**
	 * Adds a new post
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function newPost(Request $request)
	{
		$post = new Post();
		$post->user_id = $request->user()->id;
		$post->body = $request->body;
		$post->visibility = $request->visibility;
		/*if($request->tags != "")
			$post->tags = json_encode($request->tags);*/
		$post->save();
		return response()->json(['error' => false], 200);
	}

	/**
	 * Deletes a post
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function deletePost(Request $request)
	{
		$post = Post::where('id', $request->postID)->first();
		$post->delete();
		return response()->json(['error' => 'false'], 200);
	}

	/**
	 * Edits a post
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function editPost(Request $request)
	{
		$post = Post::find($request->post_id);
		$post->body = $request->body;
		$post->visibility = $request->visibility;
		$post->save();
		return response()->json(['error' => false], 200);
	}

	/**
	 * Adds a like to a post and then sends a notification
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function likePost(Request $request)
	{
		$like = new Like();

		$like->post_id = $request->postId;
		$like->user_id = $request->user()->id;
		$like->save();

		// Post
		$post = Post::find($request->postId);
		// Owner Of Post
		$user = User::find($post->user_id);
		// Send notification to the post own saying that the person like the post
		$user->notify(new PostLiked($post, $request->user()));

		return response()->json(['error' => false], 200);
	}
}
