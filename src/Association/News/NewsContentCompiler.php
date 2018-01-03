<?php

declare(strict_types=1);

namespace Francken\Association\News;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Image;
use League\HTMLToMarkdown\HtmlConverter;
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

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\ImageRenderer;

class ResponsiveImageRenderer extends ImageRenderer
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        $element = parent::render($inline, $htmlRenderer);

        $element->setAttribute('class', 'img-fluid');
        $element->setAttribute('src', news_image($element->getAttribute('src')));

        return $element;
    }
}