<?php

namespace App\Services;

use App\Models\PageRequest;
use App\Models\SearchRequest;

class SearchRequestParser
{
    /**
     * @param $content
     * @return array
     * @throws \Exception
     */
    public static function parse($content)
    {
        if (!preg_match_all('/b-content__inline_item".+?b-content__inline_item-cover.*?<a.+?<img src="(.+?)".*?span class="cat (\w+)".+?b-content__inline_item-link.+?<a.+?href="(.+?)".*?>(.+?)<\/a>.*?<div>(.+?)<\/div>/', $content, $matches)) {
            throw new \Exception("Ссылки на страницы с видео не найдены");
        }
        return self::transform($matches);
    }

    private static function transform(array $matches)
    {
        $images = &$matches[1];
        $types = &$matches[2];
        $urls = &$matches[3];
        $names = &$matches[4];
        $additions = &$matches[5];

        $result = [];
        for ($i = 0; $i < count($names); $i++) {
            if (!in_array($types[$i], PageRequest::TYPES)) {
                continue;
            }
            $result[] = [
                'image' => $images[$i],
                'type' => $types[$i],
                'url' => $urls[$i],
                'name' => $names[$i],
                'addition' => $additions[$i],
            ];
        }

        return $result;
    }
}