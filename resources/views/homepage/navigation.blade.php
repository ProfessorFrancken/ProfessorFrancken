<?php
$subItems = [
    ['url' => "/association/news", 'title' => 'News'],
    ['url' => "/association/history", 'title' => 'History'],
    ['url' => "/association/honorary-members", 'title' => 'Honerary members'],
    ['url' => "/association/boards", 'title' => 'Boards'],
    ['url' => "/association/committees", 'title' => 'Committees'],
    ['url' => "/association/francken-vrij", 'title' => 'Francken Vrij']
];
?>

<div class="header__navigation h-100">
    <div class="row no-gutters hidden-sm-down h-100">
        <div class="col-md-11 offset-md-1 align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation col-md-9">
                    <nav class="navigation__menu nav justify-content-around">
                        <a class="navigation__menu-item nav-link active" href="#">Home</a>
                        <a class="navigation__menu-item nav-link" href="#">Association</a>
                        <a class="navigation__menu-item nav-link" href="#">Carreer</a>
                        <a class="navigation__menu-item nav-link" href="#">Study</a>
                        <a class="navigation__menu-item nav-link disabled" href="#">Photos</a>

                        <a class="navigation__menu-item nav-link login-link" href="#">
                            Login
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </a>
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-end">
                        @foreach ($subItems as $item)
                            <a class="navigation__sub-menu-item nav-link active" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
