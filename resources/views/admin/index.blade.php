@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			<div class="column is-one-third">
				<div class="panel">
					<div class="panel-heading">Admin Pages</div>
					<a href="#" class="panel-block">Users</a>
					<a href="#" class="panel-block">Posts</a>
					<a href="#" class="panel-block">Photos</a>
					<a href="#" class="panel-block">Comments</a>
					<a href="#" class="panel-block">Reports</a>
				</div>
			</div>
			<div class="column is-two-thrid">
				<div class="panel">
					<div class="panel-heading">Admin Dashboard</div>
					<div class="panel-block">
						Here are some stats for the website
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="panel">
							<div class="panel-heading">Users</div>
							@foreach(\App\User::orderBy('created_at', 'desc')->limit(5)->get() as $user)
								<a href="{{ $user->profileLink() }}" class="panel-block">
									{{ $user->name }}
								</a>
							@endforeach
							<div class="panel-block">
								<a class="button is-link is-outlined is-fullwidth">
									View All Users
								</a>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="panel">
							<div class="panel-heading">Posts</div>
							@foreach(\App\Post::orderBy('created_at', 'desc')->limit(5)->get() as $post)
								<a href="{{ $post->linkToPost() }}" class="panel-block">
									{{ \Illuminate\Support\Str::words($post->body, $words = 15, $end = '...') }}
								</a>
							@endforeach
							<div class="panel-block">
								<a class="button is-link is-outlined is-fullwidth">
									View All Posts
								</a>
							</div>
						</div>
					</div>
					<div class="column">
						<div class="panel">
							<div class="panel-heading">Comments</div>
							<div class="panel-block">No Comments</div>
							<div class="panel-block">
								<a class="button is-link is-outlined is-fullwidth">
									View All Comments
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection