<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('type');
            $table->unsignedBigInteger('service_id')->nullable()->after('product_id');
            $table->unsignedBigInteger('tour_id')->nullable()->after('service_id');
            $table->unsignedBigInteger('package_id')->nullable()->after('tour_id');
            $table->string('currency', 8)->default('₸')->after('price');
            // Можно удалить старое поле item_id, если не используется
            $table->dropColumn('item_id');
        });
    }
    
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'service_id', 'tour_id', 'package_id', 'currency']);
            $table->unsignedBigInteger('item_id')->nullable();
        });
    }    
};
