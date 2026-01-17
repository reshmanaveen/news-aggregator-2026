<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function upsert(array $articles, int $sourceId)
    {
        foreach ($articles as &$article) {
            $article['source_id'] = $sourceId;
        }

        Article::upsert(
            $articles,
            ['source_id', 'external_id'],
            ['title', 'description', 'content', 'author', 'category', 'url', 'image_url', 'published_at']
        );
    }
}
