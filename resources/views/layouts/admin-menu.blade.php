<div class="column is-one-third">
	<div class="panel">
		<div class="panel-heading">Admin Pages</div>
		<a href="{{ route('admin.dashboard') }}" class="panel-block @if(Route::currentRouteName() == "admin.dashboard") is-active @endif">Dashboard</a>
		<a href="{{ route('admin.users') }}" class="panel-block @if(Route::currentRouteName() == "admin.users" || Route::currentRouteName() == "admin.user") is-active @endif">Users</a>
		<a href="#" class="panel-block">Posts</a>
		<a href="#" class="panel-block">Photos</a>
		<a href="#" class="panel-block">Comments</a>
		<a href="#" class="panel-block">Reports</a>
	</div>
</div>