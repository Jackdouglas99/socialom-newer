@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			@include('layouts.admin-menu')
			<div class="column is-two-third">
				<table class="table is-hoverable is-striped is-fullwidth">
					<thead>
					<tr>
						<th><abbr title="Post ID">ID</abbr></th>
						<th>User</th>
						<th>Body</th>
						<th>Visibility</th>
						<th>Created</th>
						<th>Actions</th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th><abbr title="Post ID">ID</abbr></th>
						<th>User</th>
						<th>Body</th>
						<th>Visibility</th>
						<th>Created</th>
						<th>Actions</th>
					</tr>
					</tfoot>
					<tbody>
					@foreach($posts as $post)
						<tr>
							<td>{{ $post->id }}</td>
							<td>{{ $post->user->name }}</td>
							<td>{{ \Illuminate\Support\Str::words($post->body, $words = 10, $end = '...') }}</td>
							<td>{{ $post->visibility }}</td>
							<td>{{ $post->created_at }}</td>
							<td>
								<div class="field has-addons">
									<p class="control">
										<a href="{{ route('admin.post', $post->id) }}" class="button is-small is-primary is-outlined">Edit</a>
									</p>
									<p class="control">
										<a href="{{ $post->linkToPost() }}" target="_blank" class="button is-small is-link is-outlined">View</a>
									</p>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
				{{ $posts->links() }}
			</div>
		</div>
	</div>
@endsection