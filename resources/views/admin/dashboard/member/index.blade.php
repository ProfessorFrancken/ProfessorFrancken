@extends('admin.layout')
@section('page-title', 'Hoi, ' . $member->fullname)

@section('content')
    <div class="row">
        <div class="col">
            <p class="lead">
                Welcome to the adtministration page of T.F.V. 'Professor Francken'.
            </p>
        </div>
    </div>
@endsection
