<?php

return [
    /**
     * Type can either be 'xml' or 'fake'
     * xml: retrieve news articles from a static xml file
     * fake: generate fake news articles using faker
     */
    'type' => env('NEWS_TYPE', 'fake'),
    'xml' => database_path('wordpress.xml'),
];
