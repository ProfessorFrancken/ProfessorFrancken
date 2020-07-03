@extends('committees.show')

@section('committee-content')
    <div>
        {!! $committee->compiled_content !!}
    </div>
@endsection
