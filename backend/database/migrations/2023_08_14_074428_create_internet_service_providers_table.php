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
        Schema::create('internet_service_providers', function (Blueprint $table) {
            $table->id();

            $table->string('address');
            $table->string('static_ip_address');
            $table->string('schema_org_channel_provider');

            $table->string('cost_participant_1')->nullable();
            $table->string('cost_participant_2')->nullable();
            $table->string('cost_participant_3')->nullable();
            $table->string('cost_participant_4')->nullable();
            $table->string('cost_participant_5')->nullable();
            $table->string('cost_participant_6')->nullable();

            $table->text('comment');

            $table->unsignedBigInteger('internet_speed_id')->nullable();
            $table->unsignedBigInteger('channel_type_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            $table
                ->foreign('organization_id')
                ->references('id')
                ->on('organizations')
                ->cascadeOnDelete();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table
                ->foreign('internet_speed_id')
                ->references('id')
                ->on('internet_speeds')
                ->nullOnDelete();

            $table
                ->foreign('channel_type_id')
                ->references('id')
                ->on('channel_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_service_providers');
    }
};
