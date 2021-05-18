<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrlViralLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srl_viral_loads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ccc_num');
            $table->string('patient_name');
            $table->string('dob');
            $table->string('date_collected');
            $table->string('art_start_date');
            $table->string('current_regimen');
            $table->string('date_art_regimen');
            $table->string('art_line');
            $table->string('justification_code');
            $table->string('selected_type');
            $table->string('selected_sex');
            $table->integer('processed');
            $table->integer('lab_id');
            $table->integer('lab_name');
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
        Schema::dropIfExists('srl_viral_loads');
    }
}
