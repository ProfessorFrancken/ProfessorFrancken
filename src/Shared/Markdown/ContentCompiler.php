<?php

declare(strict_types=1);

namespace Francken\Shared\Markdown;

use Francken\Association\News\CompiledMarkdown;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\ImageRenderer as InlineImageRenderer;
use League\CommonMark\MarkdownConverter;

final class ContentCompiler
{
    private MarkdownConverter $compiler;

    public function __construct()
    {
        $config = [
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ];
        $env = new Environment($config);
        $env->addExtension(new CommonMarkCoreExtension());
        $env->addExtension(new AttributesExtension());
        $env->addRenderer(Image::class, new ResponsiveImageRenderer(
            new InlineImageRenderer()
        ));

        $this->compiler = new MarkdownConverter($env);
    }

    public function content(string $content) : CompiledMarkdown
    {
        return CompiledMarkdown::fromSource(
            $this->compiler,
            $content
        );
    }
}
