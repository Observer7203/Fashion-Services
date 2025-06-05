<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServiceIncludesToJson extends Migration
{
    public function up()
    {
        Schema::table('service_includes', function (Blueprint $table) {
            $table->json('title')->change();
        });
    }

    public function down()
    {
        Schema::table('service_includes', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
