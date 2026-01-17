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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('source_id')->constrained();
            $table->string('external_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('author')->nullable();
            $table->string('category')->nullable();
            $table->string('url');
            $table->text('image_url')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['source_id', 'external_id']);

            // Indexes
            $table->index(['source_id', 'published_at']); // composite index for filtering + sorting
            $table->index('published_at');
            $table->index('category');
            $table->index('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
