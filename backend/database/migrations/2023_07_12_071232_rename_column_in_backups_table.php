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
        Schema::table('backups', function (Blueprint $table) {
            $table->renameColumn('type', 'description_storage');
            $table->renameColumn('storage_long_time', 'storage_server_long_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backups', function (Blueprint $table) {
            $table->renameColumn('description_storage', 'type');
            $table->renameColumn('storage_server_long_time', 'storage_long_time');
        });
    }
};
