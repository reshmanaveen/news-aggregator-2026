<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index(ArticleIndexRequest $request)
    {
        $perPage = $request->per_page ?? 20;

        $cacheKey = 'articles:' . md5(json_encode(
            $request->validated() + [
                'page'     => $request->get('page', 1),
                'per_page' => $perPage,
            ]
        ));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request, $perPage) {

            $articles = Article::with('source')
                ->when($request->q, function ($q) use ($request) {
                    $q->where(function ($sub) use ($request) {
                        $sub->where('title', 'like', "%{$request->q}%")
                            ->orWhere('description', 'like', "%{$request->q}%");
                    });
                })
                ->when(
                    $request->source,
                    fn($q) =>
                    $q->whereHas(
                        'source',
                        fn($s) =>
                        $s->where('slug', $request->source)
                    )
                )
                ->when(
                    $request->category,
                    fn($q) =>
                    $q->where('category', $request->category)
                )
                ->when(
                    $request->author,
                    fn($q) =>
                    $q->where('author', 'like', "%{$request->author}%")
                )
                ->when(
                    $request->from,
                    fn($q) =>
                    $q->whereDate('published_at', '>=', $request->from)
                )
                ->when(
                    $request->to,
                    fn($q) =>
                    $q->whereDate('published_at', '<=', $request->to)
                )
                ->orderByDesc('published_at')
                ->paginate($perPage);

            return ArticleResource::collection($articles);
        });
    }

    public function show(Article $article)
    {
        return Cache::remember(
            "article:{$article->id}",
            now()->addMinutes(30),
            fn () => new ArticleResource($article->load('source'))
        );
    }

}
