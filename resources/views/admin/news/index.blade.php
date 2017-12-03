@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h1 class="section-header">
                        News
                    </h1>

                    <p>
                        Here you can add news, which can be a blog, information from the association, advertisement or perhaps something else which I haven't thought about yet...
                    </p>

                    <a class="btn btn-outline-success" href="/admin/association/news/create">
                        <i class="fa fa-plus mr-1" aria-hidden="true"></i>
                        Write a new news post
                    </a>
                </div>

                <table class="table table-hover table-small mt-4">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th colspan="1" class="text-right">Actions</th>
                        </tr>
                    </thead>
                    @foreach ($news as $item)
                        <tr>
                            <td>
                                <small class="text-muted">
                                    {{ $item->publicationDate()->format('d M Y')}}
                                </small>
                            </td>
                            <td>
                                {{ $item->title() }}
                            </td>
                            <td class="text-right">
                                <a class="btn btn-outline-primary btn-sm mr-2" href="{{ $item->url() }}">
                                    <i class="fa fa-eye mr-1" aria-hidden="true"></i>
                                    View
                                </a>
                                <a class="btn btn-outline-primary btn-sm" href="/admin/association/news/{{ $item->id() }}">
                                    <i class="fa fa-pencil mr-1" aria-hidden="true"></i>
                                    Edit
                                </a>
                            </td>

                            </td>
                    @endforeach
                </table>
                <div class="card-body d-flex justify-content-between">
                    @if (count($news) > 0)
                        <a
                            class="card-link"
                            href="/admin/association/news?after={{ array_first($news)->publicationDate()->format('d-m-Y') }}"
                        >
                            Newer news
                        </a>

                        <a
                            class="card-link"
                            href="/admin/association/news?before={{ array_last($news)->publicationDate()->format('d-m-Y') }}"
                        >
                            Older news
                        </a>
                    @endif
                </div>
            </div>


        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title section-header agenda-header">
                        <label for="search-news">
                            Search for news
                        </label>
                    </h3>
                    <ul class="agenda-list list-unstyled">
                        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">

                            <form action="{{ url('/admin/association/news') }}" method="GET" class="form-horizontal">

                                <div class="form-group">
                                    {!! Form::text('subject', null, ['placeholder' => 'Search by subject', 'class' => 'form-control'])  !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('author', null, ['placeholder' => 'Search by author', 'class' => 'form-control'])  !!}
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-5 col-form-label">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        Published before
                                    </label>
                                    <div class="col-7">
                                        {!! Form::date('before', null, ['class' => 'form-control'])  !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-date-input" class="col-5 col-form-label">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        Published after
                                    </label>
                                    <div class="col-7">
                                        {!! Form::date('after', null, ['class' => 'form-control'])  !!}
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-block btn-primary">Apply filters</button>
                            </form>
                        </li>
                    </ul>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="card-title section-header agenda-header">
                        Manage authors
                    </h3>

                    <p>
                        Use this panel to add authors or edit the avatar and introduction text of an existing author.
                    </p>
                </div >

                <table class="table table-hover mb-0">
                    <tbody>
                        <th scope="row">Members</th>
                        <td>
                            <select class="custom-select w-100">
                                <option selected>Choose a member to edit</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </td>
                        <td>
                            <a class="btn btn-text text-success" href="#">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                Edit
                            </a>
                        </td>
                        </tr>
                        <tr>
                            <th scope="row">Committees</th>
                            <td>
                                <select class="custom-select w-100">
                                    <option selected>Choose a committee to edit</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-text text-success" href="#">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">Boards</th>
                            <td>
                                <select class="custom-select w-100">
                                    <option selected>Choose a board to edit</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-text text-success" href="#">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Companies</th>
                            <td>
                                <select class="custom-select w-100">
                                    <option selected>Choose a company to edit</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-text text-success" href="#">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="card-body">

                    <p>
                        Can't find the author you're looking for?
                    </p>

                    <a href="/admin/news/authors/create" class="btn btn-outline-primary">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                        Add new author
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
