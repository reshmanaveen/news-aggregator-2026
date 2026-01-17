<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_articles_list_endpoint_returns_paginated_data()
    {
        $source = Source::factory()->create([
            'slug' => 'guardian'
        ]);

        Article::factory()->count(3)->create([
            'source_id' => $source->id,
            'category' => 'Football',
        ]);

        $response = $this->getJson('/api/articles?category=Football');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ])
            ->assertJsonCount(3, 'data');
    }
}
