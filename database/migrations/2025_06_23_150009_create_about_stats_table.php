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
        // about_stats (id, about_page_id, stat_name, stat_value, stat_desc)
        Schema::create('about_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_page_id')->constrained()->onDelete('cascade');
            $table->string('stat_name');
            $table->string('stat_value');
            $table->string('stat_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_stats');
    }
};
