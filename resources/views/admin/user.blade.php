@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			@include('layouts.admin-menu')
			<div class="column is-two-third">
				<div class="panel">
					<div class="panel-heading">
						User Info
					</div>
					<div class="panel-block">
						Username: {{ $user->username }}
					</div>
					<div class="panel-block">
						Name: {{ $user->name }}
					</div>
					<div class="panel-block">
						Username: {{ $user->email }}
					</div>
					<div class="panel-block">
						Role:&nbsp; <span id="roleText">{{ $user->role }}</span>
					</div>
					<div class="panel-block">
						Verified:&nbsp; <span id="verifiedText">@if($user->isVerified()) Yes @else No @endif</span>
					</div>
					<div class="panel-block">
						Suspended:&nbsp; <span id="suspendedText">@if($user->isSuspended()) Yes @else No @endif</span>
					</div>
				</div>
				<div class="columns">
					<div class="column is-half">
						<div class="panel">
							<div class="panel-heading">Edit User Info</div>
							<form action="" method="post" id="infoForm" onsubmit="updateInfo(); return false;">
								<input type="hidden" name="user_id" value="{{ $user->id }}">
								<div class="panel-block">
									<div class="field is-horizontal">
										<div class="field-label is-normal">
											<label class="label">Name</label>
										</div>
										<div class="field-body">
											<div class="field">
												<p class="control">
													<input name="name" class="input is-fullwidth" type="text" placeholder="Name">
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-block">
									<div class="field is-horizontal">
										<div class="field-label is-normal">
											<label class="label">Username</label>
										</div>
										<div class="field-body">
											<div class="field">
												<p class="control">
													<input name="username" class="input is-fullwidth" type="text" placeholder="Username">
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-block">
									<div class="field is-horizontal">
										<div class="field-label is-normal">
											<label class="label">Email</label>
										</div>
										<div class="field-body">
											<div class="field">
												<p class="control">
													<input name="email" class="input is-fullwidth" type="email" placeholder="Email">
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="panel-block">
									<button class="button is-success is-outlined is-fullwidth" type="submit">Save</button>
								</div>
							</form>
						</div>
					</div>
					<div class="column is-half">
						<div class="panel">
							<div class="panel-heading">Admin Actions</div>
							<div class="panel-block" id="suspendedButtonContainer">
								@if($user->isSuspended())
									<button id="suspendedButton" class="button is-danger is-outlined is-fullwidth" onclick="updateSuspended('{{ $user->id }}', 'unsuspend')">UnSuspend User</button>
								@else
									<button id="suspendedButton" class="button is-danger is-outlined is-fullwidth" onclick="updateSuspended('{{ $user->id }}', 'suspend')">Suspend User</button>
								@endif
							</div>
							<div class="panel-block" id="verifiedButtonContainer">
								@if($user->isVerified())
									<button id="verifiedButton" class="button is-link is-outlined is-fullwidth" onclick="updateVerified('{{ $user->id }}', 'unverify')">UnVerify User</button>
								@else
									<button id="verifiedButton" class="button is-link is-outlined is-fullwidth" onclick="updateVerified('{{ $user->id }}', 'verify')">Verify User</button>
								@endif
							</div>
							<div class="panel-block">
								<div class="select is-fullwidth">
									<select name="role" id="role" onchange="updateRole('{{ $user->id }}')">
										<option value="user" @if(!$user->isStaff()) selected @endif>User</option>
										<option value="admin" @if($user->isStaff()) selected @endif>Admin</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		function updateSuspended(user_id, status) {
		    axios.post('{{ route('api.admin.user.updateSuspended') }}', {
		        userId: user_id,
				suspendStatus: status
		    })
		        .then(function (response) {
		            if(status === "unsuspend") {
                        toastr.success('The user has been successfully unsuspended', 'Success');
                        $('#suspendedText').text('No');
                        $('#suspendedButtonContainer')
							.html('<button id="suspendedButton" class="button is-danger is-outlined is-fullwidth" onclick="updateSuspended(\''+ user_id +'\', \'suspend\')">Suspend User</button>');
                    }else if(status === "suspend") {
                        toastr.success('The user has been successfully suspended', 'Success');
                        $('#suspendedText').text('Yes');
                        $('#suspendedButtonContainer')
                            .html('<button id="suspendedButton" class="button is-danger is-outlined is-fullwidth" onclick="updateSuspended(\''+ user_id +'\', \'unsuspend\')">UnSuspend User</button>');
                    }
		        })
		        .catch(function (error) {
		            if(error.response.status === 400){
		                toastr.error(error.response.data.errorText, 'Error');
					}else{
                        toastr.error(error.response.statusText, error.response.status);
					}
		        });
		}
		
		function updateVerified(user_id, status) {
			axios.post('{{ route('api.admin.user.updateVerified') }}', {
			    userId: user_id,
				verifiedStatus: status
			})
			    .then(function (response) {
                    if(status === "unverify") {
                        toastr.success('The user has been successfully unverified', 'Success');
                        $('#verifiedText').text('No');
                        $('#verifiedButtonContainer')
                            .html('<button id="verifiedButton" class="button is-link is-outlined is-fullwidth" onclick="updateVerified(\''+ user_id +'\', \'verify\')">Verify User</button>');
                    }else if(status === "verify") {
                        toastr.success('The user has been successfully verified', 'Success');
                        $('#verifiedText').text('Yes');
                        $('#verifiedButtonContainer')
                            .html('<button id="verifiedButton" class="button is-link is-outlined is-fullwidth" onclick="updateVerified(\''+ user_id +'\', \'unverify\')">UnVerify User</button>');
                    }
			    })
			    .catch(function (error) {
                    if(error.response.status === 400){
                        toastr.error(error.response.data.errorText, 'Error');
                    }else{
                        toastr.error(error.response.statusText, error.response.status);
                    }
			    });
        }
        
        function updateRole(user_id) {
            let role = document.getElementById("role").value;
            axios.post('{{ route('api.admin.user.updateRole') }}', {
                userId: user_id,
				role: role
            })
                .then(function (response) {
                    toastr.success('The user\'s role has been set to: ' + role, 'Success');
                    $('#roleText').text(role);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function updateInfo() {
			axios.post('{{ route('api.admin.user.updateInfo') }}', $('#infoForm').serialize())
			    .then(function (response) {
			        toastr.success('The user information has been saved!', 'Success');
			    })
			    .catch(function (error) {
			        console.log(error);
			    });
        }
	</script>
@endsection