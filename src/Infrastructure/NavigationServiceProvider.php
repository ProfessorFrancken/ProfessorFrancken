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
                'icon' => 'graduation-cap',
            ],
            [
                'url' => '/association',
                'title' => 'Association',
                'subItems' => [
                    ['url' => "/association/news", 'title' => 'News'],
                    ['url' => "/association/history", 'title' => 'History'],
                    ['url' => "/association/honorary-members", 'title' => 'Honorary members'],
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
                    ['url' => "/career/events", 'title' => 'Career events']
                ],
                'icon' => 'suitcase',
            ],
            [
                'url' => 'https://www.flickr.com/photos/fotocie/sets/',
                'title' => 'Photos',
                'subItems' => [],
                'icon' => 'camera',
            ]
        ];

        View::composer('layout._header', function ($view) use ($items) {
            if (Auth::check()) {
                $items[] = [
                    'url' => '/my-francken',
                    'title' => 'My Francken',
                    'subItems' => [],
                    'icon' => 'user',
                ];
            } else {
                $items[] = [
                    'url' => '/login',
                    'title' => 'Login',
                    'subItems' => [],
                    'icon' => '',
                    'class' => 'login-link',
                ];
            }

            $view->with('items', $items);
        });

        View::composer('homepage._pillars', function ($view) use ($items) {
            $view->with('associationIcon', $this->associationIcon());
        });
    }

    public function associationIcon()
    {
        $now = new DateTimeImmutable;
        $fourOClock = DateTimeImmutable::createFromFormat('H a', '4 pm');
        $fourOClockMorning = DateTimeImmutable::createFromFormat('H a', '4 am');

        if ($fourOClockMorning < $now && $now < $fourOClock) {
            return 'coffee';
        }

        return 'beer';
    }
}
