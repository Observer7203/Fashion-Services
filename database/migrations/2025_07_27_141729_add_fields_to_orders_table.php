<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->change(); // сделать nullable
        $table->string('guest_email')->nullable()->after('user_id');
        $table->string('first_name')->nullable()->after('guest_email');
        $table->string('last_name')->nullable()->after('first_name');
        $table->string('email')->nullable()->after('last_name');
        $table->string('phone')->nullable()->after('email');
        $table->string('address')->nullable()->after('phone');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['guest_email', 'first_name', 'last_name', 'email', 'phone', 'address']);
        // Не обязательно убирать nullable у user_id в down()
    });
}
};
