<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTourOptionsToJson extends Migration
{
    public function up()
    {
        Schema::table('tour_options', function (Blueprint $table) {
            $table->json('title')->change();
        });
    }

    public function down()
    {
        Schema::table('tour_options', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
