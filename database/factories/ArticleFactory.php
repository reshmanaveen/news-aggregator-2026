<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'source_id' => Source::factory(),          // links to SourceFactory
            'external_id' => $this->faker->uuid,
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->text(1000),
            'author' => $this->faker->name(),
            'category' => $this->faker->randomElement(['Football','Business','Politics','Technology']),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(800,600),
            'published_at' => now(),
        ];
    }
}
