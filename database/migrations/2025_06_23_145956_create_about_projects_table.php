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
        // about_projects (id, about_page_id, project_title, position)
        Schema::create('about_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_page_id')->constrained()->onDelete('cascade');
            $table->string('project_title');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_projects');
    }
};
