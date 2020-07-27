<?php

declare(strict_types=1);

namespace Francken\Shared\Markdown;

use Francken\Association\News\CompiledMarkdown;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Renderer\ImageRenderer;

final class ContentCompiler
{
    private CommonMarkConverter $compiler;

    public function __construct()
    {
        $env = Environment::createCommonMarkEnvironment();
        $env->addExtension(new AttributesExtension());
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer(
            new ImageRenderer()
        ));

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
}
