@extends('layout.two-column-layout')

@section('content')

    <h2 class="section-header">
        Hi, {{ Auth::user()->email }}!
    </h2>

    <p class="lead">
        Welcom to your francken member page. You can use this page to change your profile settings, view other member's contact information, view your active committees and more.
        <br>
        Use the links below or in the menu to see more information.

    </p>

    <div class="card my-3">
        <div class="card-block">
            <h3>

                <i class="fa fa-user text-primary mr-2 text-center" aria-hidden="true" style="width: 1em"></i>
                Profile
            </h3>

            <p>
                You can change your contact and study information using your profile page.
            </p>

            <a href="/my-francken/profile" class="card-link">View your profile</a>
        </div>
    </div>


    <div class="card my-3">
        <div class="card-block">
            <h3>
                <i class="fa fa-cogs text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Settings
            </h3>

            <p class="card-text">
                Change your privacy and notification settings using your settings page.
            </p>

            <a href="/my-francken/settings" class="card-link">View your settings</a>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-block">
            <h3>
                <i class="fa fa-university text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Members list
            </h3>

            <p class="card-text">
                Francken has many members both active and inactive.
            </p>

            <a href="/my-francken/members" class="card-link">View member list</a>
        </div>
    </div>


    <div class="card my-3">
        <div class="card-block">

            <h3>
                <i class="fa fa-users text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Committees
            </h3>

            <p class="card-text">
                View the committees you've joined.
            </p>

            <a href="/my-francken/committees" class="card-link">View your committees</a>
        </div>
    </div>


    <div class="card my-3">
        <div class="card-block">
            <h3>
                <i class="fa fa-calendar text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Activities
            </h3>

            <p class="card-text">
                You can either register for activities using our website, or register on one of the signup forms that you can find in our members room.
                Your activities page shows you an overview of the activities you've been registered to.
            </p>

            <a href="/my-francken/activities" class="card-link">View your activities</a>
        </div>
    </div>

    <div class="card my-3">
        <div class="card-block">

            <h3>
                <i class="fa fa-bar-chart text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Canteen
            </h3>

            <p class="card-text">
                We use our "streepsysteem" (roughly translated to "tallysystem") to keep track of any of your expenses, i.e. drinks, food and activities.
                You may use the canteen page to see your current and previous expenses.
            </p>

            <a href="/my-francken/canteen" class="card-link">View your canteen</a>
        </div>
    </div>


    <div class="card my-3">
        <div class="card-block">
            <h3>
                <i class="fa fa-trophy text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                Adtcievements
            </h3>

            <p class="card-text">
                The Adtcievements are Francken's very own Achievmeents system.
            </p>

            <a href="/my-francken/adtcievements" class="card-link">View your adtcievements</a>
        </div>
    </div>
@endsection

@section('aside')
    <div class="agenda">
        <h3 class="section-header agenda-header">
            My Francken
        </h3>
        <ul class="agenda-list list-unstyled">


            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/profile"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-user text-primary mr-2 text-center" aria-hidden="true" style="width: 1em"></i>
                                Profile
                            </h5>
                        </div>
                    </div>
                </a>

            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/settings"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-cogs text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Settings
                            </h5>
                        </div>
                    </div>
                </a>

            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/members"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-university text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Member list
                            </h5>
                        </div>
                    </div>
                </a>

            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/committees"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-users text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Committees
                            </h5>
                        </div>
                    </div>
                </a>

            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/activities"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-calendar text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Activities
                            </h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/canteen"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-bar-chart text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Canteen
                            </h5>
                        </div>
                    </div>
                </a>
            </li>

            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/my-francken/adtcievements"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-trophy text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Adtcievements
                            </h5>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('header-image')
    @component('layout.header._header_image')
    <div class="header-image__title">

    </div>
    @endcomponent
@endsection
