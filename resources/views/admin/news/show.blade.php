@extends('admin.layout')

@section('content')

    <div class="alert alert-warning">

        <strong>
            Warning!
        </strong>
        This news item was imported from our old wordpress website.
        By changing its content you might break stuff..
    </div>

    <div class="card">
        <div class="card-block">
            {!! Form::model($news, ['url' => ['admin/association/news', $news->link()], 'method' => 'put']) !!}

            <div class="row">
                <div class="col-md-6">

                    <h3>
                        Edit news item
                    </h3>

                    <div class="form-group">
                        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                        {!! Form::text('title', $news->title(), ['class' => 'form-control form-control-lg']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('link', 'Link:', ['class' => 'control-label']) !!}
                        {!! Form::text('link', $news->link(), ['class' => 'form-control', 'disabled' => true]) !!}
                    </div>

                    <div class="form-group">
                        {!!
                           Form::label(
                               'publicationDate',
                               'Author:',
                               ['class' => 'control-label']
                           )
                        !!}
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        Publication date

                        {!! Form::date('publicationDate', $news->publicationDate()->format('Y-m-d'), ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <h3>
                        Author
                    </h3>
                    <div class="form-group">
                        {!! Form::label('author', 'Author:', ['class' => 'control-label']) !!}
                        {!! Form::text('author', $news->authorName(), ['class' => 'form-control']) !!}
                    </div>

                </div>
            </div>


            <h3>
                Content
            </h3>
            <div class="row">
                <div class="col-md-6">
                    {!! Form::textarea('content', $news->content()->originalMarkdown(), ['class' => 'form-control', 'id' => 'news-item-content']) !!}
                </div>
                <div class="col-md-6">
                    <div style="max-height: 300px; overflow-y: scroll" class="card">
                        <div class="card-block">

                    {!! $news->content() !!}
                        </div>
                    </div>
                </div>
            </div>



            <hr/>

            <button class="btn btn-outline-success">
                Save
            </button>

            <button class="btn btn-warning">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

                Save (Saving this news item might override import settings)
            </button>
            {!! Form::close() !!}
        </div>
    </div>

        @push('scripts')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
        <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
        <script>
            var simplemde = new SimpleMDE({ element: document.getElementById("news-item-content") });
        </script>
        @endpush
@endsection
