@extends('pages.association')
@inject('faker', "Faker\Generator")

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            The latest news
        </h2>

        <div class="ribbon__items row no-gutters align-items-stretch my-5">
            @foreach (range(1, 12) as $r)
            <div class="col-md-6 col-lg-4" style="border-bottom: thin solid #eee; border-top: thin solid #eee;">
                <article class="h-100 preview-item d-flex flex-column justify-content-between">
                    <div>
                        <div class="news-item__header">
                            <span class="news-item__date badge preview-item__date">
                                {{ $faker->date('d M Y') }}
                            </span>
                            <span class="news-item__written-by">
                                Posted by
                                <span class="news-item__author">
                                    {{ $faker->name() }}
                                </span>
                            </span>
                        </div>
                        <h4 class="news-item__title preview-item__title">
                            {{ $faker->sentence() }}
                        </h4>
                        <p class="news-item__body">
                            {{ $faker->paragraph() }}
                        </p>
                    </div>

                    <div>
                        <a class="btn btn-inverse" href="/association/news/item">Read more</a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between">
            <a class="link-to-all-dark arrow" href="/association/news">
               Older news 
            </a>

            <a class="link-to-all-dark arrow" href="/association/news">
                Newer news
            </a>
        </div>
    </div>
@endsection
