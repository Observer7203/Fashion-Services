<?php

// database/migrations/xxxx_xx_xx_update_products_table_for_relations.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Новые поля
            $table->string('type')->after('slug'); // jewelry, wear, service, tour
            $table->string('subcategory')->nullable()->after('category');
            $table->text('short_description')->nullable()->after('description');
            $table->json('attributes')->nullable()->after('media');

            // Связи
            $table->foreignId('service_id')->nullable()->after('attributes')->constrained('services')->nullOnDelete();
            $table->foreignId('tour_id')->nullable()->after('service_id')->constrained('tours')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'subcategory', 'short_description', 'attributes', 'service_id', 'tour_id']);
        });
    }
};

