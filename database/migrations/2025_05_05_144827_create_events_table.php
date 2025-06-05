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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->json('included')->nullable();
            $table->json('dates')->nullable();
            $table->json('media')->nullable();
            $table->json('faq')->nullable();
            $table->string('frequency')->nullable();
            $table->json('seasons')->nullable();
            $table->text('historical')->nullable();
            $table->string('format')->nullable();
            $table->json('participants')->nullable();
            $table->json('organizers')->nullable();
            $table->string('location')->nullable();
            $table->json('streams')->nullable();
            $table->json('tours_included')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
