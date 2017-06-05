<div class="ribbon my-5">
    <div class="container">
        <h2 class="ribbon__header">
            The latest news
        </h2>

        <div class="ribbon__items row align-items-stretch">
            @foreach ($news as $newsItem)
                @include('homepage._news-item', ['newsItem' => $newsItem])
            @endforeach
        </div>
        <div class="text-md-right">
            <a class="link-to-all arrow" href="/association/news">
                View all news
            </a>
        </div>
    </div>
</div>
