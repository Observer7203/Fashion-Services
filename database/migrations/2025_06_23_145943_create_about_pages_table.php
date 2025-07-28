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
        // about_pages (id, banner_bg_url, about_image, about_profession, about_name, about_title, about_description, etc.)
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_bg_url')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about_profession')->nullable();
            $table->string('about_name')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_quote')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
