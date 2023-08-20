<?php

declare(strict_types=1);

namespace Francken\Association\News;

use League\CommonMark\MarkdownConverter;
use League\HTMLToMarkdown\HtmlConverter;

final class CompiledMarkdown
{
    private ?string $contents = null;

    private ?MarkdownConverter $compiler = null;

    private ?string $source = null;

    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public function __toString() : string
    {
        return $this->compiledContent() ?? '';
    }

    public static function withSource(string $contents, string $source) : self
    {
        $compiled = new self($contents);
        $compiled->source = $source;

        return $compiled;
    }

    public static function fromSource(MarkdownConverter $compiler, string $source) : self
    {
        // Instead of storing the compiled markdown we store a markdown compiler and
        // the source code so that we can lazily compile the markdown once it's requested
        // This will probably make it more difficult to store this object into a database
        $compiled = new self('');
        $compiled->contents = null;
        $compiled->compiler = $compiler;
        $compiled->source = $source;

        return $compiled;
    }

    public function originalMarkdown() : string
    {
        if ($this->source !== null) {
            return $this->source;
        }

        $converter = new HtmlConverter();
        return $converter->convert($this->contents ?? '');
    }

    public function compiledContent() : ?string
    {
        // Lazy compile
        if ($this->contents === null && $this->compiler !== null && $this->source !== null) {
            $this->contents = $this->compiler->convert($this->source)->getContent();
        }

        return $this->contents;
    }
}
