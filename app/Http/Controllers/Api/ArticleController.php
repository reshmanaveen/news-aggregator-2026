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
        'q'      => $request->q,
        'source' => $request->source,
        'page'   => $request->get('page', 1),
    ]));

    return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
        return Article::with('source')
            ->when(
                $request->q,
                fn ($q) => $q->where('title', 'like', "%{$request->q}%")
            )
            ->when(
                $request->source,
                fn ($q) => $q->whereHas(
                    'source',
                    fn ($s) => $s->where('slug', $request->source)
                )
            )
            ->paginate(20);
    });
    }
}
