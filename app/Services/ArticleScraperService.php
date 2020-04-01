<?php


namespace App\Services;

use App\Parsers\ChannelParser;

class ArticleScraperService
{
    public function scrape($url)
    {
        $xml = simplexml_load_file($url);
        ChannelParser::parse($xml);
    }
}
