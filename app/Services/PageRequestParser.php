<?php

namespace App\Services;

class PageRequestParser
{
    /**
     * @param $content
     * @return mixed
     * @throws \Exception
     */
    public static function parse($content)
    {
        if (!preg_match_all('/\[(\d+p)\](.+?\.mp4)/', $content, $matches)) {
            throw new \Exception("Ссылки на видео не найдены");
        }
        return self::transform($matches);
    }

    private static function transform($matches)
    {
        $resolutions = &$matches[1];
        $urls = &$matches[2];

        $result = [];
        for ($i = 0; $i < count($resolutions); $i++) {
            $result[] = [
                'resolution' => $resolutions[$i],
                'url' => str_replace('\\', '', $urls[$i]),
            ];
        }

        return $result;
    }
}