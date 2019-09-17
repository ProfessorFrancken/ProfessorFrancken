<?php

declare(strict_types=1);

namespace Francken\Shared\Markdown;

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
