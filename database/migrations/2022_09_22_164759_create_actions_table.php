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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('priority')->nullable();
            $table->foreignId('responsible_id')->nullable();
            $table->dateTime('plan_date')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->binary('photo_before')->nullable();
            $table->binary('photo_after')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->string('status')->nullable()->default('Created');
            $table->timestamps();
        });

        Schema::create('action_territory', function (Blueprint $table) {
            $table->foreignId('action_id')->constrained();
            $table->foreignId('territory_id')->constrained();
        });

        Schema::create('action_department', function (Blueprint $table) {
            $table->foreignId('action_id')->constrained();
            $table->foreignId('department_id')->constrained();
        });

        Schema::create('action_position', function (Blueprint $table) {
            $table->foreignId('action_id')->constrained();
            $table->foreignId('position_id')->constrained();
        });

        Schema::create('action_worker', function (Blueprint $table) {
            $table->foreignId('action_id')->constrained();
            $table->foreignId('worker_id')->constrained();
        });

        Schema::create('action_risk', function (Blueprint $table) {
            $table->foreignId('action_id')->constrained();
            $table->foreignId('risk_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
        Schema::dropIfExists('action_territory');
        Schema::dropIfExists('action_department');
        Schema::dropIfExists('action_position');
        Schema::dropIfExists('action_worker');
        Schema::dropIfExists('action_risk');
    }
};
