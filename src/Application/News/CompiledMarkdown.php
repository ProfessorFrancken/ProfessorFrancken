<?php

declare(strict_types=1);

namespace Francken\Application\News;

use League\CommonMark\CommonMarkConverter;
use League\HTMLToMarkdown\HtmlConverter;


final class CompiledMarkdown
{
    private $contents;

    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public function __toString() : string
    {
        return $this->contents;
    }

    public function originalMarkdown() : string
    {

        $converter = new HtmlConverter();
        return $converter->convert($this->contents);

        $toHtml = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        return 'moi';
    }
}
