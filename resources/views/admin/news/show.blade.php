@extends('admin.layout')

@section('content')

    <div class="alert alert-secondary">
        <a href="/admin/association/news/" >
            <i class="fa fa-angle-double-left" aria-hidden="true"></i>
            Back to news
        </a>
    </div>

    {!! Form::model($news, ['url' => ['admin/association/news', $news->link()], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-8">
            @include('admin.news._form', ['action' => 'Update'])
            @include('admin.news._publish')
        </div>

        <div class="col">
            @include('admin.news._misc')
            @include('admin.news._author')
        </div>
    </div>
    {!! Form::close() !!}

@endsection
