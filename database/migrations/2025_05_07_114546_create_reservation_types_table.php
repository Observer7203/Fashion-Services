<?php

// database/migrations/2025_05_07_000000_create_reservation_types_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservation_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // personal_shopping, wardrobe_edit и т.п.
            $table->string('name');           // Название: Шопинг-сопровождение
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservation_types');
    }
};

