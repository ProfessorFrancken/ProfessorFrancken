<?php

declare(strict_types=1);

namespace Francken\Shared\Markdown;

use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Renderer\ImageRenderer;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;

class ResponsiveImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    private ImageRenderer $imageRenderer;

    public function __construct(ImageRenderer $imageRenderer)
    {
        $this->imageRenderer = $imageRenderer;
    }

    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer) : HtmlElement
    {
        if ( ! ($inline instanceof Image)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        $element = $this->imageRenderer->render($inline, $htmlRenderer);
        $element->setAttribute('class', 'img-fluid');
        $element->setAttribute('src', news_image($element->getAttribute('src')));

        return $element;
    }

    public function setConfiguration(ConfigurationInterface $configuration) : void
    {
        $this->imageRenderer->setConfiguration($configuration);
    }
}
