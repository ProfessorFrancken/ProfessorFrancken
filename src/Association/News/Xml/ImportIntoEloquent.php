<?php

declare(strict_types=1);

namespace Francken\Association\News\Xml;

use Francken\Association\News\Eloquent\News;
use Illuminate\Console\Command;

final class ImportIntoEloquent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:import {filename : The xml source based in our database_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all news from an xml file into the database';

    private $authors;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authors = config('francken.news.authors');

        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $filename = database_path($this->argument('filename'));

        $wordpress = new FilterDuplicateNews(
            (new WordpressNewsIterator(
                $filename,
                $this->authors
            ))->getIterator()
        );

        if ($this->confirm("Clear current news table?")) {
            News::truncate();
        }

        $this->info('Importing news from xml file');
        $news = array_map(function ($news) {
            return News::fromNewsItem($news);
        }, iterator_to_array($wordpress));

        $amount = count($news);
        if ( ! $this->confirm("Store {$amount} news items?")) {
            return;
        }

        $bar = $this->output->createProgressBar(count($news));
        foreach ($news as $item) {
            $item->save();
            $bar->advance();
        }

        $bar->finish();
        $this->info("Importing completed");
    }
}
