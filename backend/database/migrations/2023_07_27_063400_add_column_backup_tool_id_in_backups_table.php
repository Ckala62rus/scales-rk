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
            $table->dropColumn('tool');

            $table
                ->unsignedBigInteger('backup_tool_id')
                ->nullable()
                ->after('backup_object_id');

            $table
                ->foreign('backup_tool_id')
                ->references('id')
                ->on('backup_tools')
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
            $table->string('tool')->nullable();
            $table->dropForeign('backups_backup_tool_id_foreign');
            $table->dropColumn('backup_tool_id');
        });
    }
};
