<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'packages',
                'included',
                'additional_options',
                'individual_preferences',
                'media',
                'seasons',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->json('packages')->nullable();
            $table->json('included')->nullable();
            $table->json('additional_options')->nullable();
            $table->json('individual_preferences')->nullable();
            $table->json('media')->nullable();
            $table->json('seasons')->nullable();
        });
    }
};
