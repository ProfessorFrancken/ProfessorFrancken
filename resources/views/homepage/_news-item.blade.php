<article class="col-md-4 d-flex flex-column news-item">
    <div style="flex: 1 1 auto;">
        <div class="news-item__header">
            <span class="news-item__date badge">
                {{ $newsItem->publicationDate()->format('d M Y') }}
            </span>
            <span class="news-item__written-by">
                Posted by
                <span class="news-item__author">
                    {{ $newsItem->authorName() }}
                </span>
            </span>
        </div>
        <h4 class="news-item__title">
            {{ $newsItem->title() }}
        </h4>
        <p class="news-item__body">
            {{ $newsItem->exerpt() }}
        </p>
    </div>

    <div>
        <a href="{{ $newsItem->url() }}" class="btn btn-inverse">
            Read more
        </a>
    </div>
</article>
