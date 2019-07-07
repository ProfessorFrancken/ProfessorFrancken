@extends('admin.layout')
@section('page-title', 'News')
@php
use Francken\Association\News\Http\AdminNewsController;
@endphp

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p>
                        Here you can add news, which can be a blog, information from the association, advertisement or perhaps something else which I haven't thought about yet...
                    </p>

                    @if (count($drafts) > 0)
                        <h3 class="card-title" >
                            Drafts
                        </h3>
                    @endif
                </div>

                @include('admin.news._table', ['news' => $drafts])

                <div class="card-body">
                    <h3 class="card-title mt-4" >
                        Published news
                    </h3>
                </div>

                @include('admin.news._table', ['news' => $news])

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

            {{--
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
                                <i class="fa fa-edit" aria-hidden="true"></i>
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
                                    <i class="fa fa-edit" aria-hidden="true"></i>
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
                                    <i class="fa fa-edit" aria-hidden="true"></i>
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
                                    <i class="fa fa-edit" aria-hidden="true"></i>
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

            --}}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a
            class="btn btn-primary"
            href="{{ action([AdminNewsController::class, 'create']) }}"
        >
            <i class="fa fa-plus mr-1" aria-hidden="true"></i>
            Write a new news post
        </a>
    </div>
@endsection
