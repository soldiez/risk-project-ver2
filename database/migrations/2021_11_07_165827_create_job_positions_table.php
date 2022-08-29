<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateJobPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_positions', function (Blueprint $table) {
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
        \Illuminate\Support\Facades\DB::table('job_positions')->insert(
            [
                'id' => 1,
                'unit_id' => 0,
                'name' => '-',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_positions');
    }
}
