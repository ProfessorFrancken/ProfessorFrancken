<?php

declare(strict_types=1);

namespace Francken\Association\News;

use Francken\Shared\Markdown\ResponsiveImageRenderer;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Image;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
use Webuni\CommonMark\TableExtension\TableExtension;

final class NewsContentCompiler
{
    private $compiler;

    public function __construct()
    {
        $env = Environment::createCommonMarkEnvironment();
        $env->addExtension(new TableExtension());
        $env->addExtension(new AttributesExtension());
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer());

        $this->compiler = new CommonMarkConverter([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ], $env);
    }

    public function content(string $content) : CompiledMarkdown
    {
        return CompiledMarkdown::fromSource(
            $this->compiler,
            $content
        );
    }

    public function exerpt(string $content) : CompiledMarkdown
    {
        $env = Environment::createCommonMarkEnvironment();
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer());
        $toHtml = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ], $env);

        return CompiledMarkdown::fromSource(
            $toHtml,
            $content
        );
    }
}
