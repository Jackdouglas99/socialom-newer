@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			@include('layouts.admin-menu')
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
								<a class="button is-link is-outlined is-fullwidth" href="{{ route('admin.users') }}">
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
								<a class="button is-link is-outlined is-fullwidth" href="{{ route('admin.posts') }}">
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