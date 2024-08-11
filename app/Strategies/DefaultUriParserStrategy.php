<?php

namespace App\Strategies;

class DefaultUriParserStrategy implements UriParserStrategy
{
    public function parse(string $uri): string
    {
        $queryString = parse_url($uri, PHP_URL_QUERY);
        if ($queryString) {
            parse_str($queryString, $queryParameters);
            return $queryParameters['id'] ?? '';
        }
        return '';
    }
}
