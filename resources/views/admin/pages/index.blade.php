@extends('admin.layout')
@section('page-title', 'Pages')

@section('content')
    <p>
        Below you can edit the contents of some of our pages.
    </p>
    <div class="card">
        <table class="table table-hover table-small">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Url</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>
                            <a href="{{ url($page->slug)}}">
                                /{{ $page->slug }}
                            </a>
                        </td>
                        <td class="text-right">
                            <a href="{{ action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'show'], ['page' => $page]) }}"
                                class="btn btn-primary btn-sm"
                            >
                                Show
                            </a>
                            <a href="{{ action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'edit'], ['page' => $page]) }}"
                                class="btn btn-primary btn-sm"
                            >
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'create']) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Add page
        </a>
    </div>
@endsection
