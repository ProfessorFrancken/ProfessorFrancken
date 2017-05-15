@extends('homepage.two-column-layout')
@inject('faker', "Faker\Generator")

@section('content')

    <h2 class="section-header">
        {{ $newsItem->title() }}
    </h2>

    <span>
        Posted on {{ $newsItem->publicationDate()->format('d M Y') }}
    </span>

    <hr>


    {!! $newsItem->content() !!}

    <hr class="my-4">

    <div class="d-flex justify-content-between mb-5">
        <div class="d-flex flex-column">
            <strong>
                Previous news
            </strong>
            <a class="" href="/association/news/item">
                {{ $faker->sentence() }}
            </a>
        </div>

        <div class="d-flex flex-column text-right">
            <strong>
                Next news
            </strong>
            <a class="" href="/association/news/item">
                {{ $faker->sentence() }}
            </a>
        </div>
    </div>

@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        Written by
    </h3>

    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <a
                href="/association/news/item"
                class="aside-link"
            >
                <div class="media align-items-center">
                    <div class="media-body">
                        <h5 class="agenda-item__header">
                            {{ $newsItem->authorName() }}
                        </h5>
                    </div>
                    <img
                        class="rounded d-flex ml-3"
                        src="https://api.adorable.io/avatars/75/0.png"
                        style="width: 75px; height: 75px; object-fit: cover; border-radius: 50%;"
                    >
                </div>
            </a>
        </li>
    </ul>

    <h5>
        About {{ $newsItem->authorName() }}
    </h5>
    <p>
        {{ $faker->paragraph() }}
    </p>

    <h5>
        Related articles
    </h5>

    <ul class="agenda-list list-unstyled">
        @foreach (range(0, $faker->numberBetween(2, 5)) as $r)
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <a
                href="/association/news/item"
                class="aside-link"
            >
                <div class="media align-items-center">
                    <div class="media-body">
                        {{ $faker->sentence() }}
                    </div>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
