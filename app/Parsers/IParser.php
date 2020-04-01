<?php

namespace App\Parsers;

use SimpleXMLElement;

interface IParser
{
    public static function parse(SimpleXMLElement $xml): void ;
}
