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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('hostname')->nullable();
            $table->string('model')->nullable();
            $table->date('date_buy')->nullable();
            $table->string('description_service')->nullable();
            $table->date('date_update')->nullable();
            $table->string('operation_system')->nullable();
            $table->string('cpu')->nullable();
            $table->integer('count_core')->nullable();
            $table->integer('count_core_with_ht')->nullable();
            $table->integer('memory')->nullable();
            $table->integer('hdd')->nullable();
            $table->integer('ssd')->nullable();
            $table->string('address')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('equipment_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('equipment_id')->references('id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('devices');
    }
};
