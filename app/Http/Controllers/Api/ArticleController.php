<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index(Request $request)
    {        
        $cacheKey = 'articles:' . md5(json_encode([
            'q'        => $request->q,
            'source'   => $request->source,
            'category' => $request->category,
            'author'   => $request->author,
            'from'     => $request->from,
            'to'       => $request->to,
            'page'     => $request->get('page', 1),
        ]));

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
            return Article::with('source')
                ->when($request->q, function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->q}%")
                    ->orWhere('description', 'like', "%{$request->q}%");
                })
                ->when($request->source, fn ($q) =>
                    $q->whereHas('source', fn ($s) =>
                        $s->where('slug', $request->source)
                    )
                )
                ->when($request->category, fn ($q) =>
                    $q->where('category', $request->category)
                )
                ->when($request->author, fn ($q) =>
                    $q->where('author', 'like', "%{$request->author}%")
                )
                ->when($request->from, fn ($q) =>
                    $q->whereDate('published_at', '>=', $request->from)
                )
                ->when($request->to, fn ($q) =>
                    $q->whereDate('published_at', '<=', $request->to)
                )
                ->orderByDesc('published_at')
                ->paginate(20);
        });

    }
}
