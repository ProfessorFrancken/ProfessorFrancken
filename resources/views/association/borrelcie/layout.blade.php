@extends('layout.two-column-layout')

@section('aside')
@php

$menu = [
    ['url' => '/borrelcie/members', 'icon' => 'fa fa-users', 'text' => 'Members'],
    ['url' => '/borrelcie/statistics', 'icon' => 'fa fa-chart-bar', 'text' => 'Statistics'],
    ['url' => action([\Francken\Association\Members\Http\ProfileActivitiesController::class, 'index']), 'icon' => 'fa fa-beer', 'text' => 'Anytimers'],
];
@endphp
<div class="agenda">
    <div class="d-flex justify-content-start">
        <h3 class="section-header agenda-header ml-2">
            Borrelcie
        </h3>
    </div>

    <ul class="agenda-list list-unstyled">
        @foreach ($menu as $item)
<li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <a
                href={{ $item['url'] }}
                class="aside-link"
            >
                <div class="media align-items-center">
                    <div class="media-body">
                        <h5 class="agenda-item__header">
                            <i class="{{ $item['icon'] }} fa-fw text-primary mr-2 text-center" aria-hidden="true" style="width: 1em"></i>
                            {{ $item['text'] }}
                        </h5>
                    </div>
                </div>
            </a>

        </li>
        @endforeach
    </ul>
</div>
@endsection
