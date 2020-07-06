@php

$menu = [
    ['link' => '/profile', 'icon' => 'fa fa-user', 'text' => 'Profile'],
    ['link' => '/profile/expenses', 'icon' => 'fa fa-chart-bar', 'text' => 'Expenses'],
];

if (Auth::user()->can('can-access-dashboard')) {
    $menu[] = ['link' => '/admin', 'icon' => 'fas fa-database', 'text' => 'Admin'];
}

$menu[] = ['link' => '/logout', 'icon' => 'fas fa-sign-out-alt', 'text' => 'Logout'];

@endphp
<div class="agenda">
    <div class="d-flex justify-content-start">
        <h3 class="section-header agenda-header ml-2">
            {{ $profile->voornaam }}
            {{ $profile->achternaam }}
        </h3>
    </div>

    <ul class="agenda-list list-unstyled">


        @foreach ($menu as $item)
<li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <a
                href={{ $item['link'] }}
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
