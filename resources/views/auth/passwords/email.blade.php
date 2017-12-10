@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-block">
                    @if (session('status'))
                        <div class="alert alert-success">

                        </div>
                        <div class="bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md" role="alert">
                            <div class="flex">
                                <i class="fa fa-info-circle"></i>
                                <div>
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="control" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left has-icons-right">
                                <input name="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" placeholder="Email Address" value="{{ old('email') }}" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                @if ($errors->has('email'))
                                    <span class="icon is-small is-right">
                                    <i class="fa fa-warning"></i>
                                </span>
                                @endif
                            </div>
                            @if ($errors->has('email'))
                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-link">Send Password Reset Link</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
