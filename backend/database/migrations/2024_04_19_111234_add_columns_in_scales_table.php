<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scales', function (Blueprint $table) {
            $table
                ->boolean("send_error_notification")
                ->default(0)
                ->after("description");

            $table
                ->text("last_error")
                ->nullable()
                ->after("send_error_notification");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scales', function (Blueprint $table) {
            $table->dropColumn("send_error_notification");
            $table->dropColumn("last_error");
        });
    }
};
