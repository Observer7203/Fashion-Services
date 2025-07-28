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
        // about_experiences (id, about_page_id, image, title, description, position)
        Schema::create('about_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_page_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('title');
            $table->text('description');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_experiences');
    }
};
