<?php

namespace App\Parsers;

use App\Models\Channel;
use SimpleXMLElement;
use Exception;

class ChannelParser implements IParser
{
    public static function parse(SimpleXMLElement $xml): void
    {
        try {

            if (isset($xml->channel) && $xml->channel) {
                $channel = $xml->channel;
                $channelData = [];
                $channelData['title'] = (string) ($channel->title ?: '');
                $channelData['url'] = (string) ($channel->link ?: '');
                $cModel = Channel::query()
                    ->where('title', $channelData['title'])
                    ->first()
                    ?: new Channel();
                $cModel->fill($channelData);
                $cModel->saveOrFail();
                if (isset($channel->item) && $channel->item) {
                    $i = 0;
                    while (isset($channel->item) && $channel->item[$i]){
                        ArticleParser::parse($channel->item[$i], $cModel);
                        $i++;
                    }
                }
            }
            else {
                throw new Exception(trans('exceptions.invalid_format'));
            }
        } catch (Exception $e) {
            throw $e;
        }

    }
}
