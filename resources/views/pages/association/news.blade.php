@extends('pages.association')

@section('title', "Recent news - T.F.V. 'Professor Francken'")

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            The latest news
        </h2>

        <div class="ribbon__items row no-gutters align-items-stretch my-5">
            @foreach ($news as $newsItem)
            <div class="col-md-6 col-lg-4" style="border-bottom: thin solid #eee; border-top: thin solid #eee;">
                <article class="h-100 preview-item d-flex flex-column justify-content-between">
                    <div>
                        <div class="news-item__header">
                            <span class="news-item__date badge preview-item__date">
                                {{ $newsItem->published_at->format('d M Y') }}
                            </span>
                            <span class="news-item__written-by">
                                Posted by
                                <span class="news-item__author">
                                    {{ $newsItem->author_name }}
                                </span>
                            </span>
                        </div>
                        <h4 class="news-item__title preview-item__title">
                            {{ $newsItem->title }}
                        </h4>
                        <p class="news-item__body">
                            {!! $newsItem->exerpt !!}
                        </p>
                    </div>

                    <div>
                        <a class="btn btn-inverse" href="{{ action([\Francken\Association\News\Http\NewsController::class, 'show'], ['news' => $newsItem]) }}">Read more</a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ action([\Francken\Association\News\Http\NewsController::class, 'archive']) }}" class="link-to-all-dark">
                Visit the news archive
            </a>
        </div>
    </div>
@endsection
