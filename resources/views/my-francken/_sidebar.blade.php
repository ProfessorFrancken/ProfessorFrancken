<div class="agenda">
    <div class="d-flex justify-content-start">
        <img src="{{ image('/images/person.png', ['width' => '50', 'height' => '30'], true) }}" class="rounded-circle border border-dark" style="width: 50px; height: 50px"/>
        <h3 class="section-header agenda-header ml-2">
            {{ $profile->voornaam }}
            {{ $profile->achternaam }}
        </h3>
    </div>

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
                href="/my-francken/finances"
                class="aside-link"
            >
                <div class="media align-items-center">
                    <div class="media-body">
                        <h5 class="agenda-item__header">
                            <i class="fa fa-bar-chart text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                            Finances
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

        @if (Auth::user()->can_access_admin)
            <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
                <a
                    href="/admin"
                    class="aside-link"
                >
                    <div class="media align-items-center">
                        <div class="media-body">
                            <h5 class="agenda-item__header">
                                <i class="fa fa-database text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                                Admin
                            </h5>
                        </div>
                    </div>
                </a>
            </li>
        @endif

        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <a
                href="/logout"
                class="aside-link"
            >
                <div class="media align-items-center">
                    <div class="media-body">
                        <h5 class="agenda-item__header">
                            <i class="fa fa-sign-out text-primary mr-2 text-center" aria-hidden="true" style="width: 1em;"></i>
                            Logout
                        </h5>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>