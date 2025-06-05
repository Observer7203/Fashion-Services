<?php

// database/migrations/xxxx_xx_xx_create_service_media_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceMediaTable extends Migration
{
    public function up()
    {
        Schema::create('service_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id'); // ID услуги
            $table->string('type'); // main, service, detail1, detail2, detail3, detail4, quote
            $table->string('media_type')->default('image'); // image, video, quote
            $table->string('path')->nullable(); // путь к файлу (img/video) или null если quote
            $table->text('quote_text')->nullable(); // если type = quote
            $table->integer('position')->nullable(); // для порядка (1,2,3,4)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_media');
    }
}
