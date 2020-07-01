@extends('layout.two-column-layout')

@section('title', "News archive - T.F.V. 'Professor Francken'")

@section('content')

    <h2 class="section-header">
        News Archive
    </h2>

    <hr>

    @if (count($news) > 0)
        <ul class="list-unstyled agenda-list">
            @foreach ($news as $item)
                <li class="agenda-item">
                    <a href="/association/news/{{ $item->slug }}" class="d-flex justify-content-between">
                        {{ $item->title }}
                        <small class="text-muted">
                            {{ $item->published_at->format('d M Y')}}
                        </small>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p>
            Could not find any news items according to your search criteria
        </p>
    @endif

    <hr>

    <div class="d-flex justify-content-between mb-5">
        {!! $news->links() !!}
    </div>
@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        <label for="search-news">
            Search the archive
        </label>
    </h3>
    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">

            <form action="{{ url('/association/news/archive') }}" method="GET" class="form-horizontal">

                <div class="form-group">
                    {!! Form::text('subject', null, ['placeholder' => 'Search by subject', 'class' => 'form-control'])  !!}
                </div>

                <div class="form-group">
                    {!! Form::text('author', null, ['placeholder' => 'Search by author', 'class' => 'form-control'])  !!}
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published before</label>
                    <div class="col-7">
                        {!! Form::date('before', null, ['class' => 'form-control'])  !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published after</label>
                    <div class="col-7">
                        {!! Form::date('after', null, ['class' => 'form-control'])  !!}
                    </div>
                </div>

                <button type="submit" class="btn btn-block btn-primary">Apply filters</button>
            </form>
        </li>
    </ul>
</div>
@endsection
