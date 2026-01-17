<?php

namespace App\Services\News;

use App\Services\News\Contracts\NewsProviderInterface;
use App\Services\News\Providers\GuardianProvider;
use App\Services\News\Providers\NewsApiProvider;
use App\Services\News\Providers\NyTimesProvider;
use InvalidArgumentException;

class NewsProviderFactory
{
    public static function make(string $slug): NewsProviderInterface
    {
        return match ($slug) {
            'newsapi' => new NewsApiProvider,
            'guardian' => new GuardianProvider,
            'nytimes' => new NyTimesProvider,
            default => throw new InvalidArgumentException("Invalid news source: {$slug}"),
        };
    }
}
