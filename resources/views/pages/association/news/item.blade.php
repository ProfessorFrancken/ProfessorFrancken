@extends('homepage.two-column-layout')
@inject('faker', "Faker\Generator")

@section('content')

    <h2 class="section-header">
        {{ $faker->sentence() }}
    </h2>

    <span>
        Posted on {{ $faker->date('d M Y') }}
    </span>

    <hr>

    @foreach (range(0, $faker->numberBetween(3, 8)) as $p)
    
        @if ($faker->boolean(20))
            <h3>{{ $faker->sentence() }}</h3>
        @endif

        @if ($faker->boolean(30))
            <h4>{{ $faker->sentence() }}</h4>
        @endif

        <p>
        {{ $faker->paragraph($faker->numberBetween(5, 11)) }}
        </p>

        @if ($faker->boolean(70))
        <p>
            @if ($faker->boolean(33))
                \[
                    H(x, y) = \frac{1}{2} y^2 + V(x).
                \]
            @elseif ($faker->boolean(33))
                \(
                    \frac{df}{dt} = (\frac{\partial}{\partial t} + \nabla_x + \nabla_\xi) f(x, \xi, t) = \Omega(f)
                \)
            @else
                $$
                f(x) = \int_{-\infty}^\infty
                \hat f(\xi)\,e^{2 \pi i \xi x}
                \,d\xi
                $$
            @endif
        </p>
        @endif

        @if ($faker->boolean(30))
            <img class="img-fluid my-3" src="http://pipsum.com/{{ $faker->numberBetween(800, 1200) }}x{{ $faker->numberBetween(100, 600) }}.jpg">
        @endif

    @endforeach

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
                            {{ $author = $faker->name() }}
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
        About {{ $author }}
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
