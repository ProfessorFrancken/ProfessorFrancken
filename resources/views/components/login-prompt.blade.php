@props([
    'title' => 'Login',
    'redirectTo' => null,
])

<div class="card bg-light">
    <div class="card-body">
        <h3 class="h5">{{ $title }}</h3>

        {{ $slot }}

        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if ($redirectTo !== null)
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}" />
            @endif

            <x-forms.email name="email" label="Email" placeholder="member@example.com" help="Use the same email address on which you receive our newsletters."/>
            <x-forms.password name="password" label="Password" />
            <x-forms.checkbox name="remember" :label="__('Remember Me')"/>

            <div class="form-group">
                <button type="submit" class="btn  btn-block btn-outline-primary">
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
