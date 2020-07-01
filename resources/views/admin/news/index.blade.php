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
