<?php

namespace App\Console\Commands;

use App\Parsers\ChannelParser;
use App\Services\ArticleScraperService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ScraperCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:articles
                {--url= : Scrape url}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape channel and articles for that channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ArticleScraperService $articleScraper)
    {
        $url = $this->option('url') ?: config('scraper.default_url');
        $articleScraper->scrape($url);
    }
}
