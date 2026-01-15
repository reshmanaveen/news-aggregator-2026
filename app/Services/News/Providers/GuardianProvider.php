<?php

namespace App\Services\News\Providers;

use App\Services\News\Contracts\NewsProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GuardianProvider implements NewsProviderInterface
{
    public function fetch(): array
    {
        $response = Http::get(config('services.guardian.url'), [
            'api-key' => config('services.guardian.key'),
            'show-fields' => 'bodyText,thumbnail',
        ]);

        if (
            $response->failed() ||
            ! isset($response['response']) ||
            ! isset($response['response']['results'])
        ) {
            return [];
        }

        return collect($response['response']['results'])->map(fn ($a) => [
            'external_id' => $a['id'],
            'title' => $a['webTitle'] ?? null,
            'description' => null,
            'content' => $a['fields']['bodyText'] ?? null,
            'author' => null,
            'category' => $a['sectionName'] ?? null,
            'url' => $a['webUrl'],
            'image_url' => $a['fields']['thumbnail'] ?? null,
            'published_at' => isset($a['webPublicationDate']) ? Carbon::parse($a['webPublicationDate'])->format('Y-m-d H:i:s') : null])->toArray();
    }
}
