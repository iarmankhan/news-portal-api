<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-news {category} {country=us} {pageSize=100} {page=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from newsapi.org';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $category = $this->argument('category');
        $country = $this->argument('country');
        $pageSize = $this->argument('pageSize');
        $page = $this->argument('page');

        $this->fetchNews($category, $country, $pageSize, $page);
    }

    /**
     * Fetch news from newsapi.org
     */
    private function fetchNews(
        string $category = null,
        string $country = null,
        int $pageSize = null,
        int $page = null
    ): void
    {
        // Fetch news from newsapi.org
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'category' => $category,
            'country' => $country,
            'pageSize' => $pageSize,
            'page' => $page,
            'apiKey' => config('services.newsapi.key'),
        ]);

        // Get the response body
        $body = $response->json();

        // Get the articles
        $articles = $body['articles'];

        // Create a transaction
        \DB::beginTransaction();

        // Loop through the articles
        foreach ($articles as $article) {
            // Skip if title is null or '[Removed]'
            if ($article['title'] === null || $article['title'] === '[Removed]') {
                continue;
            }

            $publishedAt = $article['publishedAt'];

            if ($publishedAt === '1970-01-01T00:00:00Z') {
                $publishedAt = '2021-01-01T00:00:00Z';
            }

            $url_hash = hash('sha256', $article['url']);

            // Create a new news or get the existing one
            $news = \App\Models\News::firstOrCreate(
                ['url_hash' => $url_hash], // Conditions to find existing news
                [ // Data to create new news if not exists
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'image_link' => $article['urlToImage'],
                    'author' => $article['author'],
                    'metadata' => json_encode($article['source']),
                    'published_at' => Carbon::parse($publishedAt),
                    'category' => $category,
                    'source' => $article['source']['name'],
                    'url' => $article['url'],
                ]
            );
        }

        // Commit the transaction
        \DB::commit();
    }
}
