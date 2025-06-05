<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServiceAddonsToJson extends Migration
{
    public function up()
    {
        Schema::table('service_addons', function (Blueprint $table) {
            $table->json('title')->change();
        });
    }

    public function down()
    {
        Schema::table('service_addons', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
