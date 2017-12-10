@extends('layouts.app')

@section('css')
	<style>
		.cover-container{
			height:300px;
			background: url({{ $user->banner_img }}) no-repeat center;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
		.cover-container a img {
			margin-top: 20px;
			width: 140px;
			height: 140px;
			border-radius: 50%;
			border: 10px solid rgba(255,255,255,0.3);
		}
		.profile-name{
			color: #fff;
			text-rendering: optimizelegibility;
			text-shadow: 0 0 3px rgba(0,0,0,.8);
			font-size: 40px;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="row text-center cover-container">
			<a>
				<img src="{{ $user->profile_img }}" alt="">
			</a>
			<h1 class="profile-name">
				{{ $user->name }}
			</h1>
		</div>
		<br>
		<div class="columns">
			<div class="column">
				@if($user->id != Auth::id())
					<?php
						$friendRequest = \App\FriendRequest::where('sender_user_id', $user->id)->where('recipient_user_id', Auth::id())->first();
						if(!count($friendRequest)){
							$friendRequest = \App\FriendRequest::where('sender_user_id', Auth::id())->where('recipient_user_id', $user->id)->first();
						}
					?>
					@if(count($friendRequest) && $friendRequest->sender_user_id != Auth::id())
						@if($friendRequest->status == "pending")
							<div class="panel">
								<div class="panel-heading">Do you know {{ $user->name }}?</div>
								<div class="panel-block">
									<p>To see what he shares with friends, Send him a friend request.</p>
								</div>
								<div class="panel-block">
									<div class="field has-addons">
										<p class="control">
											<a class="button is-success is-outlined is-fullwidth" href="#" onclick="updateFriendRequest({{ $friendRequest->id }}, 'accepted')">
												<span class="icon">
													<i class="fa fa-check" aria-hidden="true"></i>
												</span>
												<span>Accept Friend Request</span>
											</a>
										</p>
										<p class="control">
											<a class="button is-danger is-outlined is-fullwidth" href="#" onclick="updateFriendRequest({{ $friendRequest->id }}, 'declined')">
												<span class="icon">
													<i class="fa fa-times" aria-hidden="true"></i>
												</span>
												<span>Decline Friend Request</span>
											</a>
										</p>
									</div>
								</div>
							</div>
						@endif
					@elseif(count($friendRequest) && $friendRequest->sender_user_id == Auth::id())
						@if($friendRequest->status == "pending")
							<div class="panel">
								<div class="panel-heading">Do you know {{ $user->name }}?</div>
								<div class="panel-block">
									<p>To see what he shares with friends, Send him a friend request.</p>
								</div>
								<div class="panel-block">
									<a class="button is-link is-outlined is-fullwidth" disabled="">
									<span class="icon">
										<i class="fa fa-plus-square-o" aria-hidden="true"></i>
									</span>
										<span>Friend Request Pending</span>
									</a>
								</div>
							</div>
						@endif
					@else
						<div class="panel">
							<div class="panel-heading">Do you know {{ $user->name }}?</div>
							<div class="panel-block">
								<p>To see what he shares with friends, Send him a friend request.</p>
							</div>
							<div class="panel-block">
								<a class="button is-link is-outlined is-fullwidth" href="#" onclick="sendFriendRequest({{ $user->id }})">
									<span>Send Friend Request</span>
								</a>
							</div>
						</div>
					@endif
				@endif
				<div class="panel">
					<div class="panel-heading">Intro</div>
					@if($user->bio != "")
						<div class="panel-block">
							{{ $user->bio }}
						</div>
					@endif
				</div>
			</div>
			<div class="column is-two-thirds">
				<form action="" method="post" onsubmit="newPost(); return false;">
					<div class="panel-block">
						<p class="control">
							<textarea name="body" id="postBody" class="textarea" placeholder="Write a new post..." required></textarea>
						</p>
					</div>
					<div class="panel-block">
						<button type="submit" class="button">Post</button>
						&nbsp;
						<div class="control">
							<div class="select">
								<select name="visibility" id="postVisibility">
									<option value="public">Public</option>
									<option value="friends">Friends Only</option>
									<option value="me">Me Only</option>
								</select>
							</div>
						</div>
						&nbsp;
						<input class="input" name="postTags" id="postTags" type="tags" placeholder="Tags" >
					</div>
				</form>
				<div id="posts">
					<br>
					@foreach($posts as $post)
						<div class="post" id="post-{{ $post->id }}">
							<div class="card">
								<header class="card-header">
									<p class="card-header-title">
										<a href="{{ $post->user->profileLink() }}">{{ $post->user->name }}</a> - {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
									</p>
									<div class="dropdown is-right is-hoverable">
										<div class="dropdown-trigger">
											<a class="card-header-icon" aria-haspopup="true" aria-controls="dropdown-menu6">
											<span class="icon">
												<i class="fa fa-angle-down" aria-hidden="true"></i>
											</span>
											</a>
										</div>
										<div class="dropdown-menu" id="dropdown-menu6" role="menu">
											<div class="dropdown-content">
												<div class="dropdown-item">
													<a href="#" class="dropdown-item" onclick="reportPost({{ $post->id }});">
														Report Post
													</a>
												</div>
											</div>
										</div>
									</div>
								</header>
								<div class="card-content">
									<div class="content">
										{{ $post->body }}
										<br>
										@if($post->tags != "")
											@foreach(explode(',', json_decode($post->tags)) as $tag)
												<a href="/tag/{{ $tag }}">{{ '@' . $tag }}</a>
											@endforeach
											<br>
										@endif
										{{ $post->likes->count() }} Likes | {{ $post->shares }} Shares
									</div>
								</div>
								<footer class="card-footer">
									@if(\App\Like::where('post_id', $post->id)->where('user_id', Auth::id())->get()->count())
										<a id="unlike-{{ $post->id }}" href="#" class="card-footer-item" onclick="">UnLike</a>
									@else
										<a id="like-{{ $post->id }}" href="#" class="card-footer-item" onclick="likePost({{ $post->id }})">Like</a>
									@endif
										<a href="#" class="card-footer-item">Share</a>
									<a href="#" class="card-footer-item">Comment</a>
								</footer>
								@if(Auth::user()->isStaff() && $post->user_id != Auth::id())
									<footer class="card-footer">
										<a href="#" class="card-footer-item">Edit</a>
										<a href="#" class="card-footer-item">Delete</a>
									</footer>
								@elseif($post->user_id == Auth::user()->id)
									<footer class="card-footer">
										<a href="#" class="card-footer-item" onclick="">Edit</a>
										<a href="#" class="card-footer-item" onclick="deletePost({{ $post->id }})">Delete</a>
									</footer>
								@endif
							</div>
							<br>
						</div>
					@endforeach
					{{ $posts->render() }}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
        function reportPost(post_id) {
            swal({
                title              : 'Report a post',
                input              : 'text',
                showCancelButton   : true,
                confirmButtonText  : 'Submit Report',
                showLoaderOnConfirm: true,
                preConfirm         : (reason) => {
                    axios.post('{{ route('api.user.report.new') }}', {
                        contentType: 'post',
                        user       : '{{ Auth::id() }}',
                        postID     : post_id,
                        reason     : reason
                    })
                        .then(function (response) {
                            swal({
                                title: 'Report a post',
                                text : 'the post has been reported for the reason: ' + reason,
                                type : 'success'
                            })
                            console.log('Post ID: ' + post_id + ' has been reported for: ' + reason)
                        })
                        .catch(function (error) {
                            swal({
                                title: 'Error reporting post',
                                text : 'An error has occurred whilst trying to report the post',
                                type : 'error'
                            })
                        });
                },
                allowOutsideClick  : false
            });
        }

        function newPost() {
            axios.post('{{ route('api.user.post.new') }}', {
                body      : $('#postBody').val(),
                visibility: $('#postVisibility').val(),
                tags      : $('#postTags').val(),
            })
                .then(function (response) {
                    toastr.success('The post has been successfully created.', 'Success');
                    $('#posts').prepend(
                        '<div class="card">' +
                        '<header class="card-header">' +
                        '<p class="card-header-title">' +
                        '{{ Auth::user()->name }}' +
                        '</p>' +
                        '</header>' +
                        '<div class="card-content">' +
                        '<div class="content">' +
                        $('#postBody').val() +
                        '<br>' +
                        '<time datetime="2016-1-1"></time>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                    $('#postBody').val('');
                    $('#postTags').val('');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function deletePost(post_id) {
            axios.post('{{ route('api.user.post.delete') }}', {
                postID: post_id
			})
                .then(function (response) {
                    $('#post-'+ post_id).remove();
                    swal({
						type: 'success',
						title: 'Post Deleted',
						text: 'The post has been deleted.'
					});
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function likePost(post_id) {
            axios.post('{{ route('api.user.post.like') }}', {
                postId: post_id
            })
                .then(function (response) {
                    $('#like-' + post_id).text('Unlike');
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function sendFriendRequest(user_id) {
            axios.post('{{ route('api.user.friend-request.send') }}', {
                userId: user_id
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        function updateFriendRequest(friendRequest_id, status) {
            axios.post('{{ route('api.user.friend-request.update') }}', {
                friendRequestId    : friendRequest_id,
                friendRequestStatus: status
            })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        var file = document.getElementById("file");
        file.onchange = function(){
            if(file.files.length > 0)
                document.getElementById('filename').innerHTML = file.files[0].name;
        };

	</script>
@endsection