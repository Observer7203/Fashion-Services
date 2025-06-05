<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->foreignId('reservation_type_id')->nullable()->constrained()->onDelete('set null');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('reservation_type_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reservation_type_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reservation_type_id');
        });
    }
};
