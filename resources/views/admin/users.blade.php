@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="container">
			<br>
			<div class="columns">
				<div class="column is-one-third">
					<div class="panel">
						<div class="panel-heading">Admin Pages</div>
						<a href="#" class="panel-block active">Users</a>
						<a href="#" class="panel-block">Posts</a>
						<a href="#" class="panel-block">Photos</a>
						<a href="#" class="panel-block">Comments</a>
						<a href="#" class="panel-block">Reports</a>
					</div>
				</div>
				<div class="column is-two-third">
					<table class="table is-hoverable is-striped is-fullwidth">
						<thead>
						<tr>
							<th><abbr title="User ID">ID</abbr></th>
							<th>Username</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Verified</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tfoot>
						<tr>
							<th><abbr title="User ID">ID</abbr></th>
							<th>Username</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Verified</th>
							<th>Actions</th>
						</tr>
						</tfoot>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{ $user->id }}</td>
									<td>{{ $user->username }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->role }}</td>
									<td>@if($user->isVerified()) Yes @else No @endif</td>
									<td>
										<a href="#" class="button is-small is-primary is-outlined">Edit</a>
										<a href="{{ $user->profileLink() }}" target="_blank" class="button is-small is-link is-outlined">View</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{{ $users->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection