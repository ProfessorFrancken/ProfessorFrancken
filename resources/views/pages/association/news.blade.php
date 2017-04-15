@extends('pages.association')
@inject('faker', "Faker\Generator")

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            The latest news
        </h2>

        <div class="ribbon__items row align-items-stretch">
            @foreach (range(1, 12) as $r)
            <div class="col-md-4 news-item">
                <article class="h-100 preview-item d-flex flex-column justify-content-between">
                    <div style="">
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
                        <button class="btn btn-inverse">Read more</button>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
@endsection
