<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('label');
            $table->string('type'); // text, textarea, select, radio, checkbox, file, date, number, etc
            $table->boolean('required')->default(false);
            $table->json('options')->nullable(); // для select/radio/checkbox
            $table->integer('sort_order')->default(0);
            $table->json('validation')->nullable(); // правила валидации (min, max и пр.)
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
}