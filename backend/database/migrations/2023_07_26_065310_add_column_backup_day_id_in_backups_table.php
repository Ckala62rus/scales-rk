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
            $table->dropColumn('day');

            $table
                ->unsignedBigInteger('backup_day_id')
                ->nullable()
                ->after('description_storage');

            $table
                ->foreign('backup_day_id')
                ->references('id')
                ->on('backup_days')
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
            $table->string('day')->nullable();
            $table->dropForeign('backups_backup_day_id_foreign');
            $table->dropColumn('backup_day_id');
        });
    }
};
