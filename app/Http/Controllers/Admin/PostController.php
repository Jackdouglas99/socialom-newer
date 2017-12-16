<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function posts()
	{
		$posts = Post::orderBy('created_at', 'desc')->paginate(15);
		return view('admin.posts')->with(['posts' => $posts]);
	}

	public function post($post_id)
	{
		$post = Post::find($post_id);
		return view('admin.post')->with(['post' => $post]);
	}

	public function deletePost($post_id)
	{
		$post = Post::find($post_id);

		$post->delete();

		return redirect()->route('admin.posts')->with('success', 'The post was successfully deleted');
	}
}
