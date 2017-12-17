<?php

declare(strict_types=1);

namespace Francken\Association\News\Xml;

final class Import
{
    private $news;

    public function __construct(Repository $repo)
    {
        $this->news = $repo;
    }

    public function transferTo(
        TransferableRepo $repo
    ) {
        collect($this->news->all())->map(
            function (NewsItem $news) use ($repo) {
                $repo->transfer($news);
            }
        );
    }
}