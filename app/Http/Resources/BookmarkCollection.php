<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookmarkCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $meta = [
            'method' => $request->getMethod(),
            'endpoint' => $request->path(),
        ];

        return [
            'success' => 1,
            'code' => 200,
            'meta' => $meta,
            'data' => $this->collection,
            'message' => 'Success',
        ];
    }
}
