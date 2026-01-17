<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Source::insert([
            ['name' => 'NewsAPI', 'slug' => 'newsapi'],
            ['name' => 'The Guardian', 'slug' => 'guardian'],
            ['name' => 'New York Times', 'slug' => 'nytimes'],
        ]);
    }
}
