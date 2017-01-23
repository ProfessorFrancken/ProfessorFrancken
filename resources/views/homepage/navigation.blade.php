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
    <div class="row no-gutters">
        <div class="col-md-1 offset-md-7">
            <div class="navigation__login text-center">
                <a href="" class="navigation__login-link">
                Login<i class="fa fa-user-o" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-11 offset-md-1 align-items-center h-100">
            <div class="d-flex align-items-center h-100">
                <div class="navigation col">
                    <nav class="navigation__menu nav justify-content-start">
                        <a class="navigation__menu-item nav-link active" href="#">Home</a>
                        <a class="navigation__menu-item nav-link" href="#">Association</a>
                        <a class="navigation__menu-item nav-link" href="#">Carreer</a>
                        <a class="navigation__menu-item nav-link" href="#">Study</a>
                        <a class="navigation__menu-item nav-link disabled" href="#">Photos</a>
                    </nav>

                    <nav class="navigation__sub-menu nav justify-content-start">
                        @foreach ($subItems as $item)
                            <a class="navigation__sub-menu-item nav-link active" href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
