@if (! Auth::check())
<div
    class="login-modal"
    role="dialog"
    aria-labelledby="Login_Modal_Title"
    aria-describedby="Login_Modal_Description"
    aria-hidden="true"
>
    <div class="login-modal__body">
        <div class="text-right">
            <button class="login-modal__close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="login-modal__content">
<form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <input id="email"
                           type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="e-mail"
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

                <div class="form-group d-flex flex-column">
                    <button type="submit" class="btn btn-inverse btn-lg btn-block btn-outline-primary">
                        Login
                    </button>

                    @if (Route::has('password.request'))
                        <a class="mt-2 text-white" href="{{ route('password.request') }}">
                            <small>
                            Forgot Your Password?
                            </small>
                        </a>
                    @endif
                </div>
            </form>
            <p id="Modal_Description" class="visually-hidden">
                Login with your Francken account.
            </p>
        </div>
    </div>
</div>
@endif
