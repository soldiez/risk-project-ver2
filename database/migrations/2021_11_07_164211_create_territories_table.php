<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateTerritoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->foreignId('responsible_id')->nullable();
           // $table->foreignId('department_id')->nullable();
            $table->text('coordinate')->nullable();
            $table->text('address')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('territories')->insert(
            [
                'id' => 1,
                'unit_id' => 0,
                'name' => '-',
                'responsible_id' => 0,
//                'parent_id' => 0,
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
        Schema::dropIfExists('territories');
    }
}
