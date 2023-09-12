<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Controllers\Admin;

use Francken\Shared\Http\Requests\AdminPageRequest;
use Francken\Shared\Markdown\ContentCompiler;
use Francken\Shared\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class PagesController
{
    public function index() : View
    {
        return view('admin.pages.index', [
            'pages' => Page::all(),
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Pages'],
            ]
        ]);
    }

    public function show(Page $page) : View
    {
        return view('admin.pages.show', [
            'page' => $page,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Pages'],
                ['url' => action([self::class, 'show'], ['page' => $page]), 'text' => $page->title],
            ]
        ]);
    }

    public function create() : View
    {
        $page = new Page();

        return view('admin.pages.create')
            ->with([
                'page' => $page,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Pages'],
                    ['url' => action([self::class, 'create']), 'text' => 'Create'],
                ]
            ]);
    }

    public function edit(Page $page) : View
    {
        return view('admin.pages.edit', [
            'page' => $page,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Pages'],
                ['url' => action([self::class, 'show'], ['page' => $page]), 'text' => $page->title],
                ['url' => action([self::class, 'edit'], ['page' => $page]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function store(AdminPageRequest $request, ContentCompiler $compiler) : RedirectResponse
    {
        $markdown = $compiler->content($request->content());
        Page::create([
            'title' => $request->title(),
            'slug' => $request->slug(),
            'description' => $request->description(),
            'source_content' => $markdown->originalMarkdown(),
            'compiled_content' => $markdown->compiledContent(),
            'is_published' => $request->isPublished(),
        ]);

        return redirect()->action([self::class, 'index']);
    }

    public function update(AdminPageRequest $request, ContentCompiler $compiler, Page $page) : RedirectResponse
    {
        $markdown = $compiler->content($request->content());
        $page->update([
            'title' => $request->title(),
            'slug' => $request->slug(),
            'description' => $request->description(),
            'source_content' => $markdown->originalMarkdown(),
            'compiled_content' => $markdown->compiledContent(),
            'is_published' => $request->isPublished(),
        ]);

        return redirect()->action([self::class, 'show'], ['page' => $page]);
    }

    public function destroy(Page $page) : RedirectResponse
    {
        $page->delete();

        return redirect()->action([self::class, 'index']);
    }
}
