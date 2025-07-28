<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Удалим старые поля, если они не json
            $table->dropColumn(['title', 'slug', 'short_description', 'description', 'category', 'subcategory']);
        });

        Schema::table('products', function (Blueprint $table) {
            // Добавляем json-поля для локализации
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('short_description')->nullable();
            $table->json('description')->nullable();
            $table->json('category')->nullable();
            $table->json('subcategory')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['title', 'slug', 'short_description', 'description', 'category', 'subcategory']);

            // Восстановим строковые поля
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
        });
    }
};
