<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTourPackagesToJson extends Migration
{
    public function up()
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->json('title')->change();
        });
    }

    public function down()
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
