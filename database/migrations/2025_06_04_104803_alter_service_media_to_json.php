<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServiceMediaToJson extends Migration
{
    public function up()
    {
        Schema::table('service_media', function (Blueprint $table) {
            $table->json('quote_text')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('service_media', function (Blueprint $table) {
            $table->text('quote_text')->nullable()->change();
        });
    }
}

