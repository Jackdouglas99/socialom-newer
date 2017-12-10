@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-block">
                    <form class="control" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control has-icons-left has-icons-right">
                                <input name="name" class="input {{ $errors->has('name') ? ' is-danger' : '' }}" type="text" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-user"></i>
                                </span>
                                @if ($errors->has('name'))
                                    <span class="icon is-small is-right">
                                    <i class="fa fa-warning"></i>
                                </span>
                                @endif
                            </div>
                            @if ($errors->has('name'))
                                <p class="help is-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

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

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control has-icons-left has-icons-right">
                                <input name="password" class="input {{ $errors->has('password') ? ' is-danger' : '' }}" type="password" placeholder="Password" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-lock"></i>
                                </span>
                                @if ($errors->has('password'))
                                    <span class="icon is-small is-right">
                                    <i class="fa fa-warning"></i>
                                </span>
                                @endif
                            </div>
                            @if ($errors->has('password'))
                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <div class="field">
                            <label class="label">Confirm Password</label>
                            <div class="control has-icons-left has-icons-right">
                                <input name="password_confirmation" class="input" type="password" placeholder="Confirm Password" required>
                                <span class="icon is-small is-left">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-link">Register</button>
                            </div>
                            <div class="control">
                                <a href="{{ route('login') }}" class="button is-text">Already Have An Account?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
