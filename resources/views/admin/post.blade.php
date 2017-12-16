@extends('layouts.app')

@section('content')
	<div class="container">
		<br>
		<div class="columns">
			@include('layouts.admin-menu')
			<div class="column is-two-third">
				<div class="panel">
					<div class="panel-heading">
						Post Info
					</div>
					<div class="panel-block">
						User:&nbsp;<a href="{{ $post->user->profileLink() }}" target="_blank">{{ $post->user->name }}</a>
					</div>
					<div class="panel-block">
						Body:&nbsp;<span id="postBodyText">{{ $post->body }}</span>
					</div>
					<div class="panel-block">
						Visibility:&nbsp;<span id="postVisibilityText">{{ $post->visibility }}</span>
					</div>
					<div class="panel-block">
						Created: {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
					</div>
					<div class="panel-block">
						Last Updated: {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}
					</div>
				</div>
				<div class="columns">
					<div class="column is-half">
						<div class="panel">
							<div class="panel-heading">Edit Post Info</div>
							<form action="" method="post" id="postForm" class="control" onsubmit="updatePost(); return false;">
								<input type="hidden" value="{{ $post->id }}" name="post_id">
								<div class="panel-block">
									<label class="label">Post Body</label>
									<p class="control">
										<textarea class="textarea is-expanded" placeholder="Post Body" id="body" name="body">{{ $post->body }}</textarea>
									</p>
								</div>
								<div class="panel-block">
									<div class="control">
										<div class="select is-fullwidth">
											<select name="visibility" id="visibility">
												<option value="public" @if($post->visibility == "public") selected @endif>Public</option>
												<option value="friends" @if($post->visibility == "friends") selected @endif>Friends Only</option>
												<option value="me" @if($post->visibility == "me") selected @endif>Me Only</option>
											</select>
										</div>
									</div>
								</div>
								<div class="panel-block">
									<button class="button is-fullwidth is-link is-outlined" type="submit">Update Post</button>
								</div>
							</form>
						</div>
					</div>
					<div class="column is-half">
						<div class="panel">
							<div class="panel-heading">Admin Actions</div>
							<div class="panel-block">
								<a href="{{ route('admin.post.delete', $post->id) }}" class="button is-danger is-outlined is-fullwidth">Delete Post</a>
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
		function updatePost(){
			axios.post('{{ route('api.admin.post.updatePost') }}', $('#postForm').serialize())
			    .then(function (response) {
					$('#postBodyText').text($('#body').val());
					$('#postVisibilityText').text($("#visibility :selected").text());
					toastr.success('The post has been successfully updated.', 'Success');
			    })
			    .catch(function (error) {
			        console.log(error);
			        toastr.error('An error has occurred! Error: '+ error.response.statusText, 'Error: ' + error.response.status);
			    });
		}

	</script>
@endsection