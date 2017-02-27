<?php

namespace Francken\Infrastructure;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use DateTimeImmutable;

final class NavigationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $items = [
            [
                'url' => '/study',
                'title' => 'Study',
                'subItems' => [
                    ['url' => "/study/books", 'title' => 'Books'],
                    ['url' => "/study/research-groups", 'title' => 'Research Groups'],
                    ['url' => "/study/representation/university-council", 'title' => 'University Council'],
                    ['url' => "/study/representation/faculty-council", 'title' => 'Faculty Council'],
                ],
                'icon' => 'book',
            ],
            [
                'url' => '/association',
                'title' => 'Association',
                'subItems' => [
                    ['url' => "/association/news", 'title' => 'News'],
                    ['url' => "/association/history", 'title' => 'History'],
                    ['url' => "/association/honorary-members", 'title' => 'Honerary members'],
                    ['url' => "/association/boards", 'title' => 'Boards'],
                    ['url' => "/association/committees", 'title' => 'Committees'],
                    ['url' => "/association/francken-vrij", 'title' => 'Francken Vrij']
                ],
                //    'icon' => 'beer',
                'icon' => $this->associationIcon(),
            ],
            [
                'url' => '/career',
                'title' => 'Career',
                'subItems' => [
                    ['url' => "/career/job-openings", 'title' => 'Job openings'],
                    ['url' => "/career/companies", 'title' => 'Company profiles'],
                    ['url' => "/career/excursions", 'title' => 'Excursions']
                ],
                'icon' => 'briefcase',
            ],
        ];

        View::composer('homepage._header', function ($view) use ($items) {
            if (Auth::check()) {
                $items[] = [
                    'url' => 'https://www.flickr.com/photos/fotocie/sets/',
                    'title' => 'Photos',
                    'subItems' => [],
                    'icon' => 'camera',
                ];

                $items[] = [
                    'url' => '/logout',
                    'title' => 'Profile',
                    'subItems' => [],
                    'icon' => 'user',
                ];
            } else {
                $items[] = [
                    'url' => '/login',
                    'title' => 'Login',
                    'subItems' => [],
                    'icon' => 'user',
                    'class' => 'login-link'
                ];
            }

            $view->with('items', $items);
        });
    }

    public function associationIcon()
    {
        $now = new DateTimeImmutable;
        $fourOClock = DateTimeImmutable::createFromFormat('H a', '4 pm');
        $fourOClockMorning = DateTimeImmutable::createFromFormat('H a', '4 pm');

        if ($fourOClockMorning < $now && $now < $fourOClock) {
            return 'coffee';
        }

        return 'beer';
    }
}
