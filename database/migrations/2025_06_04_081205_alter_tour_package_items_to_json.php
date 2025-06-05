<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTourPackageItemsToJson extends Migration
{
    public function up()
    {
        Schema::table('tour_package_items', function (Blueprint $table) {
            $table->json('content')->change();
        });
    }

    public function down()
    {
        Schema::table('tour_package_items', function (Blueprint $table) {
            $table->string('content')->change();
        });
    }
}
