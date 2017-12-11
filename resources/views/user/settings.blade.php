@extends('layouts.app')

@section('css')
	<style>
		#tab_container .container_item {
			display: none;
		}

		#tab_container .container_item.is-active {
			display: block;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="tabs is-centered" id="tab_header">
			<ul>
				<li class="item is-active" data-option="1"><a>Profile</a></li>
				<li class="item" data-option="2"><a>Password</a></li>
				<li class="item" data-option="3"><a>Privacy</a></li>
			</ul>
		</div>
		<div class="box" id="tab_container">
			<div class="container_item is-active" data-item="1">
				<form action="" id="profileForm" class="control" method="post" onsubmit="saveProfile(); return false;">
					<div class="columns">
						<div class="column is-half">
							<div class="field">
								<label class="label">Username</label>
								<div class="control has-icons-left has-icons-right">
									<input name="username" class="input" type="text" placeholder="Currently: {{ Auth::user()->username }}">
									<span class="icon is-small is-left">
										<i class="fa fa-user"></i>
									</span>
								</div>
							</div>
							<div class="field">
								<label class="label">Email</label>
								<div class="control has-icons-left has-icons-right">
									<input name="email" class="input" type="email" placeholder="Currently: {{ Auth::user()->email }}">
									<span class="icon is-small is-left">
										<i class="fa fa-envelope"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="column is-half">
							<div class="field">
								<label class="label">Name</label>
								<div class="control has-icons-left has-icons-right">
									<input name="name" class="input" type="text" placeholder="Currently: {{ Auth::user()->name }}">
									<span class="icon is-small is-left">
										<i class="fa fa-user"></i>
									</span>
								</div>
							</div>
							<div class="field">
								<label class="label">Bio</label>
								<div class="control has-icons-left has-icons-right">
									<input name="bio" class="input" type="text" placeholder="Currently: {{ Auth::user()->bio }}">
									<span class="icon is-small is-left">
										<i class="fa fa-align-justify"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<center>
						<button class="button is-primary">Save</button>
					</center>
				</form>
			</div>
			<div class="container_item" data-item="2">
				<form id="passwordForm" action="" class="control" method="post" onsubmit="savePassword(); return false;">
					<div class="columns">
						<div class="column is-half">
							<div class="field">
								<label class="label">Current Password</label>
								<div class="control has-icons-left has-icons-right">
									<input id="current_password" name="current_password" class="input" type="password" placeholder="Current Password" required>
									<span class="icon is-small is-left">
										<i class="fa fa-user"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="column is-half">
							<div class="field">
								<label class="label">New Password</label>
								<div class="control has-icons-left has-icons-right">
									<input id="password" name="password" class="input" type="password" placeholder="New Password" required>
									<span class="icon is-small is-left">
										<i class="fa fa-user"></i>
									</span>
								</div>
							</div>
							<div class="field">
								<label class="label">Confirm New Password</label>
								<div class="control has-icons-left has-icons-right">
									<input id="password_confirmation" name="password_confirmation" class="input" type="password" placeholder="Confirm New Password" required>
									<span class="icon is-small is-left">
										<i class="fa fa-user"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
					<center>
						<button type="submit" class="button is-primary">Save</button>
					</center>
				</form>
			</div>
			<div class="container_item" data-item="3">
				<form id="privacyForm" action="" class="control" method="post" onsubmit="savePrivacy(); return false;">
					<div class="columns">
						<div class="column is-half">
							<div class="field">
								<label class="label">Post Visibility</label>
								<div class="select">
									<select name="activity_visibility">
										<option value="public" @if(Auth::user()->activity_visibility == "public") selected @endif>Public</option>
										<option value="friends" @if(Auth::user()->activity_visibility == "friends") selected @endif>Friends Only</option>
										<option value="me" @if(Auth::user()->activity_visibility == "me") selected @endif>Me Only</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<center>
						<button type="submit" class="button is-primary">Save</button>
					</center>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
        $(document).ready(function() {
            $('#tab_header ul li.item').on('click', function() {
                var number = $(this).data('option');
                $('#tab_header ul li.item').removeClass('is-active');
                $(this).addClass('is-active');
                $('#tab_container .container_item').removeClass('is-active');
                $('div[data-item="' + number + '"]').addClass('is-active');
            });
        });

        function saveProfile() {
            axios.post('{{ route('api.user.settings.profile') }}', $('#profileForm').serialize())
                .then(function (response) {
                    swal({
						type: 'success',
						title: 'Saved',
						text: 'Your information has been updated.'
					});
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function savePassword() {
            axios.post('{{ route('api.user.settings.password') }}', $('#passwordForm').serialize())
                .then(function (response) {
                    swal({
						type: 'success',
						title: 'Saved',
						text: 'Your password has been successfully updated'
					});
                    $('#current_password').val("");
                    $('#password').val("");
                    $('#password_confirmation').val("");
                })
                .catch(function (error) {
                    if(error.response.status === 409)
					{
						swal({
							type: 'info',
							title: 'Error',
							text: 'Your current password did not match.'
						});
                        $('#current_password').val("");
                        $('#password').val("");
                        $('#password_confirmation').val("");
					}else{
                        console.log(error);
					}
                });
        }

        function savePrivacy() {
            axios.post('{{ route('api.user.settings.privacy') }}', $('#privacyForm').serialize())
                .then(function (response) {
                    swal({
                        type: 'success',
                        title: 'Saved',
                        text: 'Your privacy settings has been successfully updated'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
	</script>
@endsection