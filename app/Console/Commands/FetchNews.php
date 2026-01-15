<?php

namespace App\Console\Commands;

use App\Models\Source;
use App\Repositories\ArticleRepository;
use App\Services\News\NewsProviderFactory;
use Illuminate\Console\Command;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news articles from external APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sources = Source::all();

        foreach ($sources as $source) {
            $provider = NewsProviderFactory::make($source->slug);
            $articles = $provider->fetch();

            app(ArticleRepository::class)->upsert($articles, $source->id);
        }

        $this->info('News fetched successfully.');
    }
}
