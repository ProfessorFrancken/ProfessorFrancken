@extends('pages.association')
@inject('faker', "Faker\Generator")

@section('sub-menu')
    @include('layout._subnavigation', [
        'list' => [
            ['url' => "/post", 'title' => 'All'],
            ['url' => "/news", 'title' => 'News'],
            ['url' => "/blog", 'title' => 'Blog'],
        ]
    ])
@endsection

@section('main-content')
    <div class="container">
        <h2 class="section-header">
            The latest news
        </h2>

        <div class="ribbon__items row align-items-stretch">
            @foreach (range(1, 12) as $r)
                @component('homepage._news-item')
                    @slot('title')
                    {{ $faker->sentence() }}
                    @endslot

                    @slot('date')
                        {{ $faker->date('d M Y') }}
                    @endslot


                    @slot('author')
                        {{ $faker->name() }}
                    @endslot

                    {{ $faker->paragraph() }}
                @endcomponent
            @endforeach
        </div>
        <div class="text-md-right">
            <a class="link-to-all arrow" href="/association/news">
                View all news
            </a>
        </div>
    </div>
@endsection
