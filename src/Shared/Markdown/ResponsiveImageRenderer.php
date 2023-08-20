<?php

declare(strict_types=1);

namespace Francken\Shared\Markdown;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Extension\CommonMark\Renderer\Inline\ImageRenderer;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class ResponsiveImageRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    private ImageRenderer $imageRenderer;

    public function __construct(ImageRenderer $imageRenderer)
    {
        $this->imageRenderer = $imageRenderer;
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer) : HtmlElement
    {
        if ( ! ($node instanceof Image)) {
            throw new InvalidArgumentException('Incompatible node type: ' . \get_class($node));
        }

        $node->data->append('attributes/class', 'img-fluid');
        $node->data->set(
            'attributes/src',
            image(
                $node->data->get('attributes/src'),
                [
                    'width' => 600,
                    'height' => 600,
                ],
                true
            )
        );
        return $this->imageRenderer->render($node, $childRenderer);
    }

    public function setConfiguration(ConfigurationInterface $configuration) : void
    {
        $this->imageRenderer->setConfiguration($configuration);
    }
}
