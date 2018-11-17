@php

$menu = [
    ['link' => '/profile', 'icon' => 'fa fa-user', 'text' => 'Profile'],
//    ['link' => '/profile/settings', 'icon' => 'fa fa-cogs', 'text' => 'Settings'],
//    ['link' => '/profile/members', 'icon' => 'fa fa-university', 'text' => 'Member list'],
    ['link' => '/profile/expenses', 'icon' => 'fa fa-chart-bar', 'text' => 'Expenses'],
//    ['link' => '/profile/committees', 'icon' => 'fa fa-users', 'text' => 'Committees'],
//    ['link' => '/profile/activities', 'icon' => 'fa fa-calendar', 'text' => 'Activities'],
//    ['link' => '/profile/adtcievements', 'icon' => 'fa fa-trophy', 'text' => 'Adtcievements'],
];

if (Auth::user()->can_access_admin) {
    $menu[] = ['link' => '/admin', 'icon' => 'fas fa-database', 'text' => 'Admin'];
}

$menu[] = ['link' => '/logout', 'icon' => 'fas fa-sign-out-alt', 'text' => 'Logout'];

@endphp
<div class="agenda">
    <div class="d-flex justify-content-start">
        <img src="{{ image('/images/person.png', ['width' => '50', 'height' => '30'], true) }}" class="rounded-circle border border-dark" style="width: 50px; height: 50px"/>
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
