<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<script>
            document.addEventListener('DOMContentLoaded', function () {
                // Get all "navbar-burger" elements
                var $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
                // Check if there are any navbar burgers
                if ($navbarBurgers.length > 0) {
                    // Add a click event on each of them
                    $navbarBurgers.forEach(function ($el) {
                        $el.addEventListener('click', function () {
                            // Get the target from the "data-target" attribute
                            var target = $el.dataset.target;
                            var $target = document.getElementById(target);
                            // Toggle the class on both the "navbar-burger" and the "navbar-menu"
                            $el.classList.toggle('is-active');
                            $target.classList.toggle('is-active');
                        });
                    });
                }
            });
		</script>
		@yield('css')
	</head>
	<body>
		<div id="app">
			<nav class="navbar is-primary">
				<div class="navbar-brand">
					<a class="navbar-item" href="{{ route('index') }}">
						<img src="{{ asset('logo-light.png') }}"
							 alt="Socialom">
					</a>
					<div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
				<div id="navbarExampleTransparentExample" class="navbar-menu">
					<div class="navbar-start">
						<a class="navbar-item" href="{{ route('index') }}">
							Home
						</a>
					</div>
					<div class="navbar-end">
						@guest
							<a class="navbar-item" href="{{ route('login') }}">
								Login
							</a>
							<a class="navbar-item" href="{{ route('register') }}">
								Register
							</a>
						@else
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link" href="#">
									<span class="badge is-badge-success is-badge-outlined" data-badge="{{ Auth::user()->unreadNotifications->count() }}">
										Notifications
									</span>
								</a>
								<div class="navbar-dropdown is-right is-boxed">
									@if(Auth::user()->unreadNotifications->count())
										@foreach(Auth::user()->unreadNotifications as $notification)
											@if($notification->type == "App\Notifications\FriendRequestNotification")
												<div class="notif">
													<a class="navbar-item notification" href="{{ \App\User::find($notification->data['sender'])->profileLink() }}">
														{{  \App\User::find($notification->data['sender'])->name  }} Sent you a Friend Request
													</a>
												</div>
											@elseif($notification->type == "App\Notifications\FriendRequestAcceptedNotification")
												<div class="notif">
													<a class="navbar-item notification" href="{{ \App\User::find($notification->data['sender'])->profileLink() }}">
														{{  \App\User::find($notification->data['sender'])->name  }} Accepted your Friend Request
													</a>
												</div>
											@elseif($notification->type == "App\Notifications\NewReportNotification")
												@php($report = \App\Report::find($notification->data['report_id']))
												<div class="notif">
													<a class="navbar-item notification" href="#">
														The post you reported is under review.
													</a>
												</div>
											@elseif($notification->type == "App\Notifications\PostLiked")
												<div class="notif">
													<a class="navbar-item" href="{{ Auth::user()->profileLink() }}/#post-{{ $notification->data['post_id'] }}">
														{{  \App\User::find($notification->data['user_id'])->name  }} Liked Your Post
													</a>
												</div>
											@endif
										@endforeach
										<a class="navbar-item" href="#" onclick="notificationMarkAsRead()">Mark all as read</a>
									@else
										<a href="#" class="navbar-item has-text-centered">No Notifications Found</a>
									@endif
								</div>
							</div>
							<div class="navbar-item has-dropdown is-hoverable">
								<a class="navbar-link" href="{{ Auth::user()->profileLink() }}">
									{{ Auth::user()->name }}
								</a>
								<div class="navbar-dropdown is-right is-boxed">
									<a class="navbar-item" href="{{ Auth::user()->profileLink() }}">
										Profile
									</a>
									<a class="navbar-item" href="{{ route('settings') }}">
										Settings
									</a>
									<hr class="navbar-divider">
									<a href="{{ route('logout') }}"
									   onclick="event.preventDefault();
									document.getElementById('logout-form').submit();"
									   class="navbar-item">
										Logout
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</div>
							</div>
							@if(Auth::user()->role == "admin")
								<a class="navbar-item" href="{{ route('admin.dashboard') }}">
									Admin
								</a>
							@endif
						@endguest
					</div>
				</div>
			</nav>

			@yield('content')
		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="https://wikiki.github.io/js/tagsinput.js"></script>
		{!! App\Support\Helpers\NotificationDisplay::displayNotifications() !!}
		<script>
			function notificationMarkAsRead() {
				axios('{{ route('api.user.notification.markasread') }}')
					.then(function (response) {
                        $('.notif').remove();
                        console.log(response);
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		</script>
		@yield('js')
	</body>
</html>
