<?php

namespace App\Strategies;

interface UriParserStrategy
{
    public function parse(string $uri): string;
}
