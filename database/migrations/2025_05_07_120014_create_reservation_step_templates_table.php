<?php

// database/migrations/2025_05_07_000001_create_reservation_step_templates_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservation_step_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_type_id')->constrained()->onDelete('cascade');
            $table->string('step_key');        // application, payment и т.д.
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('order')->default(0); // порядок
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservation_step_templates');
    }
};

