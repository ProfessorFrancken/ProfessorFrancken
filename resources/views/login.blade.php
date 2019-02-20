@extends('layout.one-column-layout')
@section('title', "Login - T.F.V. 'Professor Francken'")

@section('content')

    <div class="row d-flex justify-content-center">
        <div class="col-sm-6">
            <div class="alert alert-warning">
                <strong>Login is currently disabled.</strong>
            </div>
            <h1 class="section-header">
                <i class="fa fa-user" aria-hidden="true"></i>
                Login
            </h1>

            {!! Form::open(['url' => route('login')]) !!}
                <div class="form-group">
                    <label for="email">Email</label>
                    {!! Form::email('email', null, ['placeholder' => 'member@professorfrancken.nl', 'class' => 'form-control', 'id' => 'email']) !!}
                </div>
                <div class="form-group">
                    <label for="passphrase">Passphrase</label>
                    {!! Form::password('passphrase', ['placeholder' => 'A super  secret passphrase', 'class' => 'form-control', 'id' => 'password']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Login', ['class' => 'btn btn-lg btn-block btn-outline-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
