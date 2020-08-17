@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fas fa-key"></i>
        Change password
    </h4>


    <div class="card my-3">
        {!!
               Form::open([
                   'url' => action([\Francken\Association\Members\Http\PasswordController::class, 'update']),
               ])
        !!}
        <div class="card-body">

            @method('PUT')
                <div class="form-group">
                    <label for="name">Current password</label>
                    {!!
                           Form::password(
                               'current_password',
                               [
                                   'class' => 'form-control' . ($errors->has('current_password') ? ' is-invalid' : ''),
                                   'id' => 'current_password',
                                   'required' => 'required',
                               ]
                           )
                    !!}
                    @error('current_password')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="password">password</label>
                    {!!
                           Form::password(
                               'password',
                               [
                                   'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                                   'placeholder' => '',
                                   'id' => 'password',
                                   'required' => 'required',
                                   'minlength' => 8,
                               ]
                           )
                    !!}
                    @error('password')
                    <p class="invalid-feedback">
                        {{ $message  }}
                    </p>
                    @else
                    <small class="form-text text-muted">
                        Passwords must be at least 8 characters long.
                    </small>
                    @enderror
                </div>

        </div>
        <div class="card-footer">
            <x-forms.submit class="btn btn-primary">Change password</x-forms.submit>
        </div>
        {!! Form::close() !!}
    </div>
    <p class="mt-3">
        <small>
            <a class="text-muted" href="{{ route('password.request') }}" tabindex="-1">
                Did you forgot your password? Click <strong>here</strong> to reset it.
            </a>
        </small>
    </p>
@endsection
