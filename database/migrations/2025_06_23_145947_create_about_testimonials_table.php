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
        // about_testimonials (id, about_page_id, text, author, author_photo)
        Schema::create('about_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_page_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->string('author')->nullable();
            $table->string('author_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_testimonials');
    }
};
