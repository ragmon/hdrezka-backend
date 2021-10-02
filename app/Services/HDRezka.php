<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HDRezka
{
    public static function getSearchResult($query)
    {
        return Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36'
            ])
            ->get(config('hdrezka.search_result_url') . $query);
    }

    public static function getSearchHints($query)
    {
        //
    }

    public static function getVideoPage($url)
    {
        return Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36'
            ])
            ->get($url);
    }
}