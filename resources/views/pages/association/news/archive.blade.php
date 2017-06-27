@extends('homepage.two-column-layout')
@inject('faker', "Faker\Generator")

@section('content')

    <h2 class="section-header">
        News Archive
    </h2>

    <hr>

    <ul class="list-unstyled agenda-list">
        @foreach ($news as $item)
        <li class="agenda-item">
            <a href="{{ $item->url() }}" class="d-flex justify-content-between">
                {{ $item->title() }}
                <small class="text-muted">
                    {{ $item->publicationDate()->format('d M Y')}}
                </small>
            </a>
        </li>
        @endforeach
    </ul>

    <hr>

    <div class="d-flex justify-content-between mb-5">
        <a
            class="link-to-all-dark arrow"
            href="/association/news/archive?after={{ array_first($news)->publicationDate()->format('d-m-Y') }}"
        >
            Newer news
        </a>

        <a
            class="link-to-all-dark arrow"
            href="/association/news/archive?before={{ array_last($news)->publicationDate()->format('d-m-Y') }}"
        >
            Older news
        </a>
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

            <form>
                <div class="form-group">
                    <input type="text" class="form-control" id="search-news" placeholder="Search by subject">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="search-author" placeholder="Search by author">
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published before</label>
                    <div class="col-7">
                        <input class="form-control" type="date" id="example-date-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published after</label>
                    <div class="col-7">
                        <input class="form-control" type="date" id="example-date-input">
                    </div>
                </div>

                <button type="submit" class="btn btn-block btn-primary">Apply filters</button>
            </form>
        </li>
    </ul>
</div>
@endsection
