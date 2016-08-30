<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;

use Francken\Domain\Posts\Events\PostWritten;
use Francken\Domain\Posts\Post;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Posts\PostCategory;
use Francken\Domain\Posts\PostRepository;

use Francken\Application\ReadModel\PostList\PostList;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostList::all();
        return view('admin.post.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('admin.post.create');
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

        return redirect('/admin/post');
    }

    public function show($id)
    {
        $post = PostList::where('uuid', $id)->first();
        return view('admin.post.show', [
            'post' => $post
        ]);
    }

    public function edit($id)
    {
        $post = PostList::where('uuid', $id)->first();
        return view('admin.post.edit', [
            'post' => $post
        ]);
    }

    public function update(Request $req, PostRepository $repo, $id)
    {
        $post = $repo->load($id);
        $post->edit($req->input('name'), $req->input('goal'));

        $repo->save($post);

        return redirect('/admin/committee/' . $id);
    }

    public function destroy($id, PostRepository $repo)
    {
        $post = $repo->load($id);
        $post->remove();
        return redirect('/admin/post');
    }
}
