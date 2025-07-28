<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Удаляем longtext media
            $table->dropColumn('media');
        });

        Schema::table('products', function (Blueprint $table) {
            // Заново создаём как json
            $table->json('media')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('media');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->longText('media')->nullable();
        });
    }
};
