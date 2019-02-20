@extends('layout.one-column-layout')
@section('title', "Reset password - T.F.V. 'Professor Francken'")

@section('content')
    <div class=" d-flex justify-content-center my-4">
        <div class="card p-5 mx-3 mx-md-5 w-100">
            <h1 class="section-header">
                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                Reset password
            </h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">Email</label>

                    <input id="email"
                           type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           placeholder="member@professorfrancken.nl"
                           value="{{ $email ?? old('email') }}"
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
                    <label for="password">Password</label>

                    <input id="password"
                           type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password"
                           required
                    >

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password-confirm">
                        Confirm password
                    </label>

                    <input id="password-confirm"
                           type="password"
                           class="form-control"
                           name="password_confirmation"
                           required
                    >
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block btn-outline-primary">
                        Reset password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
