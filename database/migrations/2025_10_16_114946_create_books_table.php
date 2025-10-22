<?php

use App\Models\Author;
use App\Models\BookRating;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Author::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('image');
            $table->text('short_desc');
            $table->longText('synopsis');
            $table->date('published_at');
            $table->json('languages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
