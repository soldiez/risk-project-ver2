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
            $table->text('short_name');
            $table->text('long_name')->nullable();
            $table->text('phone_main')->nullable();
            $table->text('phone_reserve')->nullable();
            $table->text('email')->nullable();
            $table->foreignId('manager_id')->nullable();
            $table->foreignId('safety_manager_id')->nullable();
            $table->text('legal_address')->nullable();
            $table->text('post_address')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->string('status')->nullable();
            $table->binary('logo_unit')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('units')->insert(
            [
                'id' => 1,
                'short_name' => '-',
                'long_name' => '-',
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
        Schema::dropIfExists('units');
    }
};
