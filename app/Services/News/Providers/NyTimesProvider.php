<?php

namespace App\Services\News\Providers;

use App\Services\News\Contracts\NewsProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NyTimesProvider implements NewsProviderInterface
{
    public function fetch(): array
    {
        $response = Http::get(config('services.nytimes.url'), [
            'api-key' => config('services.nytimes.key'),
        ]);

        $data = $response->json();

        if ($response->failed() || ! isset($data['response']) || ! isset($data['response']['docs'])) {
            return [];
        }

        return collect($data['response']['docs'])->map(fn ($a) => [
            'external_id' => $a['_id'],
            'title' => $a['headline']['main'] ?? null,
            'description' => $a['abstract'] ?? null,
            'content' => $a['lead_paragraph'] ?? null,
            'author' => $a['byline']['original'] ?? null,
            'category' => $a['section_name'] ?? null,
            'url' => $a['web_url'] ?? null,
            'image_url' => null,
            'published_at' => isset($a['pub_date']) ? Carbon::parse($a['pub_date'])->format('Y-m-d H:i:s') : null,
        ])->toArray();

    }
}
