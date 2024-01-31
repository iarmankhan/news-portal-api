<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListNewsRequest;
use App\Models\News;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsController extends Controller
{
    // Get all news articles
    public function index(ListNewsRequest $request): LengthAwarePaginator
    {
        // Get the query parameters
        $params = $request->validated();

        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;
        $search = $params['search'] ?? null;

        $category = $params['category'] ?? null;

        // Get the news articles
        $query = News::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy('published_at', 'desc');

        // Return the news articles
        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
