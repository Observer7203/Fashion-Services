<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterToursToJson extends Migration
{
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('subtitle')->nullable()->change();
            $table->json('short_description')->nullable()->change();
            $table->json('description')->nullable()->change();
            $table->json('faq')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('subtitle')->nullable()->change();
            $table->text('short_description')->nullable()->change();
            $table->longText('description')->nullable()->change();
            $table->text('faq')->nullable()->change();
        });
    }
}
