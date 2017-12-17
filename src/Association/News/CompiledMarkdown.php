<?php

declare(strict_types=1);

namespace Francken\Association\News;

use League\CommonMark\CommonMarkConverter;
use League\HTMLToMarkdown\HtmlConverter;


final class CompiledMarkdown
{
    private $contents = null;
    private $compiler = null;
    private $source = null;

    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    public static function withSource(string $contents, string $source) : CompiledMarkdown
    {
        $compiled = new self($contents);
        $compiled->source = $source;

        return $compiled;
    }

    public static function fromSource(CommonMarkConverter $compiler, string $source) : CompiledMarkdown
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

    public function __toString() : string
    {
        // Lazy compile
        if ($this->contents === null && $this->compiler !== null && $this->source !== null) {
            $this->contents = $this->compiler->convertToHtml($this->source);
        }

        return $this->contents;
    }

    public function originalMarkdown() : string
    {
        if ($this->source !== null) {
            return $this->source;
        }

        $converter = new HtmlConverter();
        return $converter->convert($this->contents);
    }
}
