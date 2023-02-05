<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->references('id')->on('doctors');
            $table->string('state')->default('available');
            $table->date('date');
            $table->time('time');
            $table->timestamps();
            $table->unique(['doctor_id', 'date', 'time']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appoitnment_sltos');
    }
}
