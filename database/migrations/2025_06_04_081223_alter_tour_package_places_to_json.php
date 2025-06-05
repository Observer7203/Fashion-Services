<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTourPackagePlacesToJson extends Migration
{
    public function up()
    {
        Schema::table('tour_package_places', function (Blueprint $table) {
            $table->json('name')->change();
        });
    }

    public function down()
    {
        Schema::table('tour_package_places', function (Blueprint $table) {
            $table->string('name')->change();
        });
    }
}
