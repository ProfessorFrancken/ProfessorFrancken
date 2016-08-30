<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Posts;

use Francken\Domain\Posts\PostCategory;
use InavlidArgumentException;

class PostCategoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function a_category_can_only_be_created_from_a_string()
    {
        $type = PostCategory::fromString("blog");

        $this->assertInstanceOf(PostCategory::class, $type);
        $this->assertEquals((string) $type, "blog");
    }

    /** @test */
    public function it_can_only_be_a_blog_or_news_post()
    {
        $this->expectException(\InvalidArgumentException::class);
        $type = PostCategory::fromString("foo");
    }

    /** @test */
    public function it_cannot_be_directly_constructed()
    {
        $this->expectException(\Error::class);
        $type = new PostCategory("blog");
    }
}
