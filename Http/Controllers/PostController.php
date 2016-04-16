<?php

namespace Http\Controllers;

use Illuminate\Http\Request;

use Francken\Posts\Post;
use Francken\Posts\PostId;

use Francken\Posts\Events\PostWritten;
use Francken\Posts\PostRepository;

use App\ReadModel\PostList\PostList;

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
        $id = PostId::generate();
        $post = Post::create(
            $id,
            $req->input('title'),
            $req->input('content'));

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
        $post = App\ReadModel\PostList\PostList::where('uuid', $id)->first();
        return view('admin.post.edit', [
            'post' => $post
        ]);
    }

    public function update(Request $req, $id)
    {
        $post = $repo->load($id);
        $post->edit($req->input('name'), $req->input('goal'));

        return redirect('/admin/committee/' . $id);
    }

    public function destroy($id)
    {

    }
}
