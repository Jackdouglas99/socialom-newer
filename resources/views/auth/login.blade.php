@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <br>
            <div class="panel">
                <div class="panel-heading">Login</div>
                <div class="panel-block">
                    <form class="control" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left has-icons-right">
                                <input name="email" class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
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
                            <input id="switchRoundedDefault" type="checkbox" name="remember" class="switch is-rounded" {{ old('remember') ? 'checked' : '' }}>
                            <label for="switchRoundedDefault">Remember Me</label>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button type="submit" class="button is-link">Login</button>
                            </div>
                            <div class="control">
                                <a href="{{ route('password.request') }}" class="button is-text">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
