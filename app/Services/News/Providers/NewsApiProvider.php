<?php

namespace App\Services\News\Providers;

use App\Services\News\Contracts\NewsProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApiProvider implements NewsProviderInterface
{
    public function fetch(): array
    {
        $response = Http::get(config('services.newsapi.url'), [
            'apiKey' => config('services.newsapi.key'),
            'language' => 'en',
        ]);

        if ($response->failed() || ! isset($response['articles'])) {
            return [];
        }

        return collect($response['articles'])->map(fn ($a) => [
            'external_id' => md5($a['url']),
            'title' => $a['title'] ?? null,
            'description' => $a['description'] ?? null,
            'content' => $a['content'] ?? null,
            'author' => $a['author'] ?? null,
            'category' => null,
            'url' => $a['url'],
            'image_url' => $a['urlToImage'] ?? null,
            'published_at' => isset($a['publishedAt']) ? Carbon::parse($a['publishedAt'])->format('Y-m-d H:i:s') : null,
        ])->toArray();
    }
}
