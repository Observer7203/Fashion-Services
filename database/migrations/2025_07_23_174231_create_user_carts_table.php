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
        Schema::create('user_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('tour_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable(); // Вот это добавляем для тура
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->json('options')->nullable(); // сюда можно кидать id выбранных add-ons, количество участников и т.д.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_carts');
    }
};
