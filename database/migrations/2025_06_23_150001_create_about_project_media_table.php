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
        // about_project_media (id, about_project_id, media_type, media_url, position)
        Schema::create('about_project_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_project_id')->constrained()->onDelete('cascade');
            $table->enum('media_type', ['image', 'video'])->default('image');
            $table->string('media_url');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_project_media');
    }
};
