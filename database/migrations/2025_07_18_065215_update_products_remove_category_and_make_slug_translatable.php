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
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'slug')) {
                $table->dropColumn('slug');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('products', 'subcategory')) {
                $table->dropColumn('subcategory');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
        });
    
        Schema::table('products', function (Blueprint $table) {
            $table->json('slug')->nullable();
        });
    }    
};
