<article class="col-md-4 d-flex flex-column news-item">
    <div style="flex: 1 1 auto;">
        <div class="news-item__header">
            <span class="news-item__date badge">
                {{ $date }}
            </span>
            <span class="news-item__written-by">
                Posted by
                <span class="news-item__author">
                    {{ $author }}
                </span>
            </span>
        </div>
        <h4 class="news-item__title">
            {{ $title }}
        </h4>
        <p class="news-item__body">
            {{ $slot }}
        </p>
    </div>

    <div>
        <button class="btn btn-inverse">Read more</button>
    </div>
</article>
