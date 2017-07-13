@extends('homepage.two-column-layout')

@section('title', $newsItem->title() . " - T.F.V. 'Professor Francken'")
@section('description', $newsItem->exerpt())

@section('content')

    <h2 class="section-header">
        {{ $newsItem->title() }}
    </h2>

    <span>
        Posted on {{ $newsItem->publicationDate()->format('d M Y') }}
    </span>

    <hr>


    <div class="news-item__content">
        {!! $newsItem->content() !!}
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between mb-5">
        <div class="d-flex flex-column">
            <strong>
                Previous news
            </strong>
            <a class="" href="{{ $newsItem->previousNewsItem()->url() }}">
                {{ $newsItem->previousNewsItem()->title() }}
            </a>
        </div>

        {{-- Note: the latest news item does not have any next news item --}}
        <div class="d-flex flex-column text-right">
            <strong>
                Next news
            </strong>
            <a class="" href="{{ $newsItem->nextNewsItem()->url() }}">
                {{ $newsItem->nextNewsItem()->title() }}
            </a>
        </div>
    </div>

@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Written by
    </h3>

    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <div class="media align-items-center">
                <div class="media-body">
                    <h5 class="agenda-item__header">
                        {{ $newsItem->authorName() }}
                    </h5>
                </div>
                <img
                    class="rounded d-flex ml-3"
                    src="{{ $newsItem->authorPhoto() }}"
                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                >
            </div>
        </li>
    </ul>

    @if (count($newsItem->relatedNewsItems()) > 0)
        <h5>
            Related articles
        </h5>

        <ul class="agenda-list list-unstyled">
            @foreach ($newsItem->relatedNewsItems() as $related)
                <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                    <a
                        href="{{ $related->url() }}"
                        class="aside-link"
                    >
                        <div class="media align-items-center">
                            <div class="media-body">
                                {{ $related->title() }}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
