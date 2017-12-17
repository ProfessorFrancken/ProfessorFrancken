<?php

declare(strict_types=1);

namespace Francken\Association\News\Http;

use Francken\Association\News\Repository as NewsRepository;
use Illuminate\Http\Request;
use Francken\Association\News\Eloquent\News;
use Francken\Application\News\Author;
use Francken\Application\News\CompiledMarkdown;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Image;
use League\HTMLToMarkdown\HtmlConverter;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
use Webuni\CommonMark\TableExtension\TableExtension;

use League\Period\Period;
use DateTimeImmutable;

/**
 * Note that since the logic of news is quite trivial
 * we will simply use Eloquent here.
 */
final class AdminNewsController
{
    private $news;

    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    public function index()
    {
        $news = $this->news->search(
            $this->periodForPagination(),
            request()->input('subject', null),
            request()->input('author', null)
        );

        dd($news);


        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $req, PostRepository $repo)
    {
        //Validate doesn't work?
        // $this->validate($req, [
        //     'title' => 'required|max:255',
        //     'content' => 'required',
        //     'type' => 'in:blog,news',
        //     'publishes_at' => 'date',
        // ]);

        $id = PostId::generate();

        $post = Post::createDraft(
            $id,
            $req->input('title'),
            $req->input('content'),
            PostCategory::fromString($req->input('type'))
        );

        $post->setPublishDate(\Carbon\Carbon::now()); /// @todo

        $repo->save($post);

        return redirect('/admin/news');
    }

    public function show($link)
    {
        $news = $this->news->byLink($link);

        return view('admin.news.show', [
            'news' => $news
        ]);
    }

    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();

        return view('admin.news.edit', [
            'post' => $post
        ]);
    }

    public function update(Request $req, $link)
    {
        // Note that for read actions we normally use the news repository
        // however since now we want to make changes we will use an eloquent model
        $news = News::byLink($link)->firstOrNew([]);
        $news->changeAuthor(
            new Author(
                $req->input('author'),
                ''
            )
        );
        $news->changeTitle($req->input('title'));


        $env = Environment::createCommonMarkEnvironment();
        $env->addExtension(new TableExtension());
        $env->addExtension(new AttributesExtension());
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer());

        $markdown = new CommonMarkConverter([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ], $env);

        $news->changeContents(
            CompiledMarkdown::fromSource(
                $markdown,
                $req->input('content')
            )
        );

        dd($req->all(), $news);


        // Check if it should be published


        return view('admin.news.show', [
            'news' => $news->toNewsItem()
        ]);

        $post = $repo->load($id);
        $post->edit($req->input('name'), $req->input('goal'));

        $repo->save($post);

        return redirect('/admin/committee/' . $id);
    }

    public function destroy($id)
    {
        // Note that for read actions we normally use the news repository
        // however since now we want to make changes we will use an eloquent model
        $news = News::byLink($link)->get();
        $news->archive();
        $news->save();

        return redirect('/admin/association/news/' . $news->toNewsItem()->link());
    }

    private function periodForPagination() : Period
    {
        // Enable artificial pagination
        if (request()->has('before') && request()->has('after')) {
            $before = new DateTimeImmutable(request()->input('before', '-2 years'));
            $after = new DateTimeImmutable(request()->input('after', 'now'));

            return new Period(
                $after,
                $before
            );
        }

        if (request()->has('before')) {
            $before = new DateTimeImmutable(request()->input('before', '-2 years'));

            return new Period(
                $before->sub(DateInterval::createFromDateString('2 years')),
                $before
            );
        }

        if (request()->has('after')) {
            $after = new DateTimeImmutable(request()->input('after', 'now'));

            return new Period(
                $after,
                $after->add(DateInterval::createFromDateString('2 years'))
            );
        }

        return new Period(
            $start = new DateTimeImmutable('-2 years'),
            $end = new DateTimeImmutable('now')
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