@extends('homepage.two-column-layout')
@inject('faker', "Faker\Generator")

<?php

// Enable artificial pagination
if (request()->has('before')) {
    $before = new DateTimeImmutable(request()->input('before', '-2 years'));
    $start = $before->sub(DateInterval::createFromDateString('2 years'));
    $end = $before;
} elseif (request()->has('after')) {
    $after = new DateTimeImmutable(request()->input('after', 'now'));
    $start = $after;
    $end = $after->add(DateInterval::createFromDateString('2 years'));
} else {
    $start = new DateTimeImmutable('-2 years');
    $end = new DateTimeImmutable('now');
}

$news = array_reverse(
    array_sort(
        array_map(
            function($news) use ($faker, $start, $end) {
                return [
                    'title' => $faker->sentence(),
                    'author' => $faker->name(),
                    'date' => $faker->dateTimeBetween( 
                        $start->format('y-m-d'),
                        $end->format('y-m-d')
                    ),
                ];
            }, 
            range(0, 15)
        ),
        function ($news) {
            return $news['date'];
        }
    )
);

?>

@section('content')

    <h2 class="section-header">
        News Archive        
    </h2>

    <hr>

    <ul class="list-unstyled agenda-list">
        @foreach ($news as $item)
        <li class="agenda-item">
            <a href="/association/news/item" class="d-flex justify-content-between">
                {{ $item['title'] }}
                <small class="text-muted">
                    {{ $item['date']->format('d M Y')}}
                </small> 
            </a>
        </li>
        @endforeach
    </ul>

    <hr>

    <div class="d-flex justify-content-between mb-5">
        <a 
            class="link-to-all-dark arrow" 
            href="/association/news/archive?after={{ array_first($news)['date']->format('d-m-Y') }}"
        >
            Newer news
        </a>

        <a 
            class="link-to-all-dark arrow" 
            href="/association/news/archive?before={{ array_last($news)['date']->format('d-m-Y') }}"
        >
            Older news 
        </a>
    </div>
@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        <label for="search-news">
            Search the archive
        </label>
    </h3>
    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">

            <form>
                <div class="form-group">
                    <input type="text" class="form-control" id="search-news" placeholder="Search by subject">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" id="search-author" placeholder="Search by author">
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published before</label>
                    <div class="col-7">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-date-input" class="col-5 col-form-label">Published after</label>
                    <div class="col-7">
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Apply filters</button>
            </form>
        </li>
    </ul>
</div>
@endsection