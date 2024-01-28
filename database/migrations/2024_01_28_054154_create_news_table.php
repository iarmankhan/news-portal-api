<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('image_link')->nullable();
            $table->string('author')->nullable();
            $table->json('metadata')->nullable();
            $table->text('url');
            $table->string('url_hash')->unique(); // hashed version of URL for uniqueness.
            $table->timestampTz('published_at');
            $table->string('category')->nullable();
            $table->string('source')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
