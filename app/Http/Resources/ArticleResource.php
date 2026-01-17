<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'content'      => $this->content,
            'author'       => $this->author,
            'category'     => $this->category,
            'image_url'    => $this->image_url,
            'url'          => $this->url,
            'published_at' => optional($this->published_at)->toIso8601String(),
            'source' => [
                'id'   => $this->source->id,
                'name' => $this->source->name,
                'slug' => $this->source->slug,
            ],
        ];
    }
}
