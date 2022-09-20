<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('unit_id')->nullable();
            $table->text('name');
            $table->foreignId('manager_id')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->nullable();
         //   NestedSet::columns($table);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('departments')->insert(
            [
                'id' => 1,
                'unit_id' => 0,
                'name' => '-',
//                'responsible_id' => 0,
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
        Schema::dropIfExists('departments');
    }
}
