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
        Schema::create('scale_weights', function (Blueprint $table) {
            $table->id();
            $table->float("weight", 8, 2);
            $table->unsignedBigInteger('scale_id');
            $table->timestamps();

            $table
                ->foreign('scale_id')
                ->references('id')
                ->on('scales')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scale_weights');
    }
};
