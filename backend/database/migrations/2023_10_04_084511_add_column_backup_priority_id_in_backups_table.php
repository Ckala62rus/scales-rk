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
            $table
                ->unsignedBigInteger('backup_priority_id')
                ->nullable()
                ->after('backup_tool_id');

            $table
                ->foreign('backup_priority_id')
                ->references('id')
                ->on('backup_priorities')
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
            $table->dropForeign('backups_backup_priority_id_foreign');
            $table->dropColumn('backup_priority_id');
        });
    }
};
