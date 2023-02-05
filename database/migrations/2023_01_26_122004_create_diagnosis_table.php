<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->references('id')->on('patients');
            $table->foreignId('doctor_id')->references('id')->on('doctors');
            $table->string('disease');
            $table->string('state');
            $table->text('note');
            $table->unique(['patient_id', 'disease', 'state']);
            $table->timestamps();
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
        Schema::dropIfExists('diagnosis');
    }
}
