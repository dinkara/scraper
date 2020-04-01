<?php

namespace App\Parsers;

use App\Models\Article;
use App\Models\Channel;
use Carbon\Carbon;
use KubAT\PhpSimple\HtmlDomParser;
use SimpleXMLElement;
use Exception;

class ArticleParser implements IParser
{
    public static function parse(SimpleXMLElement $item, Channel $channel = null): void
    {
        try {
            if ($item) {
                $articleData['channel_id'] = $channel ? $channel->id : null;
                $articleData['title'] = (string) ($item->title ?: '');
                $link = (string) ($item->link ?: '');
                $articleData['url'] = $link ?: '';
                $html = file_get_html($link);
                $articleData['date'] = self::getDate($html);
                $articleData['content'] = self::getContent($html);
                $article = Article::query()
                    ->where('title', $articleData['title'])
                    ->where('channel_id', $articleData['channel_id'])
                    ->first()
                    ?: new Article();
                $article->fill($articleData);
                $article->saveOrFail();
            } else {
                throw new Exception(trans('exceptions.invalid_format'));
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    private static function getDate($html)
    {
        foreach($html->find('b[class="d-md-none"]') as $b) {
            return Carbon::parse(str_replace('. ', '-', $b->plaintext));
        }
    }

    private static function getContent($html)
    {
        foreach($html->find('div[class="row d-flex align-items-stretch teaserGrid-list__slide"]') as $content) {
            return $content->plaintext;
        }
    }
}
