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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('products')->insert(
            [
                'id' => 1,
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
        Schema::dropIfExists('products');
    }
};
