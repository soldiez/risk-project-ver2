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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();

            $table->string('hazard_info')->nullable();
            $table->text('base_risk_info')->nullable();

            $table->foreignId('hazard_category_id')->nullable();
            $table->foreignId('injured_body_part_id')->nullable();

            $table->foreignId('risk_method_id')->nullable();

            $table->text('base_preventive_action')->nullable();
            $table->foreignId('base_severity_id')->nullable();
            $table->foreignId('base_probability_id')->nullable();
            $table->foreignId('base_frequency_id')->nullable();
            $table->string('base_calc_risk')->nullable();

            $table->text('prop_preventive_action')->nullable();
            $table->foreignId('prop_severity_id')->nullable();
            $table->foreignId('prop_probability_id')->nullable();
            $table->foreignId('prop_frequency_id')->nullable();
            $table->string('prop_calc_risk')->nullable();

            $table->dateTime('create_date_time')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->dateTime('review_date')->nullable();
            $table->foreignId('auditor_id')->nullable();
            $table->dateTime('control_review_date')->nullable();
            $table->string('risk_status')->nullable();

            $table->timestamps();
        });

        Schema::create('risk_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->string('status')->nullable();
            $table->text('info')->nullable();
            $table->string('parameters')->nullable();
            $table->boolean('is_risk_frequency')->nullable();
            $table->boolean('is_risk_calculated')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_severities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_method_id');
            $table->string('name');
            $table->string('sort')->nullable();
            $table->string('value')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_probabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_method_id');
            $table->string('name');
            $table->string('sort')->nullable();
            $table->string('value')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_frequencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_method_id');
            $table->string('name');
            $table->string('sort')->nullable();
            $table->string('value')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_method_id');
            $table->string('name');
            $table->string('sort')->nullable();
            $table->string('value')->nullable();
            $table->string('colour')->nullable();
            $table->text('info')->nullable();
            $table->foreignId('risk_severity_id')->nullable();
            $table->foreignId('risk_probability_id')->nullable();
            $table->timestamps();
        });

        Schema::create('risk_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('hazard_categories', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('injured_body_parts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        //"Many to many" relationship tables

        Schema::create('risk_method_unit', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_method_id');
            $table->integer('unit_id');
            $table->timestamps();
        });


//        Schema::create('risk_unit', function (Blueprint $table) {
//            $table->id();
//            $table->integer('risk_id');
//            $table->integer('unit_id');
//            $table->timestamps();
//        });

        Schema::create('risk_territory', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_id');
            $table->integer('territory_id');
            $table->timestamps();
        });

        Schema::create('department_risk', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_id');
            $table->integer('department_id');
            $table->timestamps();
        });

        Schema::create('position_risk', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_id');
            $table->integer('position_id');
            $table->timestamps();
        });

        Schema::create('action_risk', function (Blueprint $table) {
            $table->id();
            $table->integer('risk_id');
            $table->integer('action_id');
            $table->timestamps();
        });
        Schema::create('author_risk', function (Blueprint $table) {
            $table->id();
            $table->integer('worker_id');
            $table->integer('risk_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('risks');
        Schema::dropIfExists('risk_methods');
        Schema::dropIfExists('risk_severities');
        Schema::dropIfExists('risk_probabilities');
        Schema::dropIfExists('risk_frequencies');
        Schema::dropIfExists('risk_zones');
        Schema::dropIfExists('risk_statuses');
        Schema::dropIfExists('hazard_categories');
        Schema::dropIfExists('injured_body_parts');
        Schema::dropIfExists('risk_unit');
        Schema::dropIfExists('risk_territory');
        Schema::dropIfExists('risk_method_unit');
        Schema::dropIfExists('department_risk');
        Schema::dropIfExists('position_risk');
        Schema::dropIfExists('action_risk');
        Schema::dropIfExists('author_risk');
    }
};
