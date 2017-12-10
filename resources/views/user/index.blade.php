@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			<div class="column">
				<div class="bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md" role="alert">
					<div class="flex">
						<svg class="fill-current h-6 w-6 text-teal mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
						<div>
							<p class="font-bold">Info</p>
							<p class="text-sm">This site is in early alpha stages.</p>
						</div>
					</div>
				</div>
				<br>
				<div class="panel bg-black-base">
					<a href="{{ Auth::user()->profileLink() }}" class="panel-block">{{ Auth::user()->name }}</a>
					<a class="panel-block is-active">
						<span class="panel-icon">
						  <i class="fa fa-newspaper-o"></i>
						</span>
						News Feed
					</a>
					<a href="{{ route('terms') }}" class="panel-block">
						Terms
					</a>
				</div>
			</div>
			<div class="column is-four-fifths">
				<div class="panel">
					<form action="" method="post" onsubmit="newPost(); return false;">
						<div class="panel-block">
							<p class="control">
								<textarea name="body" id="postBody" class="textarea" placeholder="Write a new post..." required></textarea>
							</p>
						</div>
						<div class="panel-block">
							<button type="submit" class="button">Post</button>
							&nbsp;
							{{--<div class="file has-name">
								<label class="file-label">
									<input class="file-input" id="file" type="file" name="resume" disabled="">
									<span class="file-cta">
										<i class="fa fa-file" aria-hidden="true"></i>
									</span>
									<span class="file-name" id="filename">
										Choose A File...
									</span>
								</label>
							</div>
							&nbsp;--}}
							<div class="control">
								<div class="select">
									<select name="visibility" id="postVisibility">
										<option value="public">Public</option>
										<option value="friends">Friends Only</option>
										<option value="me">Me Onyl</option>
									</select>
								</div>
							</div>
							&nbsp;
							<input class="input" name="postTags" id="postTags" type="tags" placeholder="Tags" >
						</div>
					</form>
				</div>
				<div id="posts">
					@foreach($posts as $post)
						<div class="post" id="post-{{ $post->id }}">
							<div class="card">
								<header class="card-header">
									<p class="card-header-title">
										<a href="{{ $post->user->profileLink() }}">
											{{ $post->user->name }}
										</a> - {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
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

        var file = document.getElementById("file");
        file.onchange = function(){
            if(file.files.length > 0)
            	document.getElementById('filename').innerHTML = file.files[0].name;
        };

	</script>
@endsection