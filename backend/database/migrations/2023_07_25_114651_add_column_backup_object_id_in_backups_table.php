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
            $table->dropColumn('object');

            $table
                ->unsignedBigInteger('backup_object_id')
                ->nullable()
                ->after('hostname');

            $table
                ->foreign('backup_object_id')
                ->references('id')
                ->on('backup_objects')
                ->nullOnDelete();
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
            $table->string('object')->nullable();
            $table->dropForeign('backups_backup_object_id_foreign');
            $table->dropColumn('backup_object_id');
        });
    }
};
