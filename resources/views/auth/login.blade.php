@extends('layout.one-column-layout')
@section('title', "Login - T.F.V. 'Professor Francken'")

@section('content')
    <div class="d-flex justify-content-center">
        <div class="card p-5 mx-3 mx-md-5 w-100">
            <div class="alert alert-warning">
                <strong>Login is currently disabled.</strong>
            </div>
            <h1 class="section-header">
                <i class="fa fa-user" aria-hidden="true"></i>
                Login
            </h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <input id="email"
                           type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="member@professorfrancken.nl"
                           required
                           autofocus
                    >

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Passphrase</label>
                    <input id="password"
                           type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password"
                           placeholder="Your password"
                           required
                    >

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block btn-outline-primary">
                        Login
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
