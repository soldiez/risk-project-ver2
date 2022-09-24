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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('long_name')->nullable();
            $table->text('phone_main')->nullable();
            $table->text('phone_reserve')->nullable();
            $table->text('email')->nullable();
            $table->foreignId('manager_id')->nullable();
            $table->foreignId('safety_manager_id')->nullable();
            $table->text('legal_address')->nullable();
            $table->text('post_address')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('default_risk_method_id')->nullable(); //default risk method Id
            $table->string('status')->nullable();
            $table->binary('logo_unit')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('units')->insert([ 'id' => 1, 'name' => '-', 'long_name' => '-']);

        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->foreignId('responsible_id')->nullable();
            $table->text('coordinate')->nullable();
            $table->text('address')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('territories')->insert(['id' => 1, 'unit_id' => 0, 'name' => '-', 'responsible_id' => 0]);

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->foreignId('manager_id')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('departments')->insert(['id' => 1, 'unit_id' => 0, 'name' => '-']);

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->text('grade')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('positions')->insert(['id' => 1, 'unit_id' => 0, 'name' => '-']);

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('personnel_number')->unique()->nullable();
            $table->foreignId('position_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->date('birthday')->nullable();
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();
            $table->string('type')->nullable(); //products, process, services
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('activities')->insert(['id' => 1, 'name' => '-',]);

//        Schema::create('processes', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('unit_id')->nullable();
//            $table->string('name');
//            $table->text('description')->nullable();
//            $table->foreignId('parent_id')->nullable();
//            $table->string('status')->nullable();
//            $table->timestamps();
//        });
//        \Illuminate\Support\Facades\DB::table('processes')->insert(['id' => 1, 'name' => '-',]);
//
//        Schema::create('services', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('unit_id')->nullable();
//            $table->string('name');
//            $table->text('description')->nullable();
//            $table->foreignId('parent_id')->nullable();
//            $table->string('status')->nullable();
//            $table->timestamps();
//        });
//        \Illuminate\Support\Facades\DB::table('services')->insert(['id' => 1, 'name' => '-',]);

        Schema::create('department_territory', function (Blueprint $table) {
            $table->foreignId('department_id')->constrained();
            $table->foreignId('territory_id')->constrained();
            $table->timestamps();
        });

        Schema::create('activity_territory', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained();
            $table->foreignId('territory_id')->constrained();
            $table->timestamps();
        });
        Schema::create('activity_department', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->timestamps();
        });
        Schema::create('activity_position', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained();
            $table->foreignId('position_id')->constrained();
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
        Schema::dropIfExists('units');
        Schema::dropIfExists('territories');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('workers');
        Schema::dropIfExists('activities');
//        Schema::dropIfExists('processes');
//        Schema::dropIfExists('services');
        Schema::dropIfExists('department_territory');
        Schema::dropIfExists('activity_territory');
        Schema::dropIfExists('activity_department');
        Schema::dropIfExists('activity_position');
    }
};
