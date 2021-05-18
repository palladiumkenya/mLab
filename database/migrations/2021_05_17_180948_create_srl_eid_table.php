<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrlEidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srl_eid', function (Blueprint $table) {
            $table->increments('id');
            $table->string('selected_sex');
            $table->string('selected_regimen');
            $table->string('selected_alive');
            $table->string('hein_number');
            $table->string('patient_name');
            $table->string('dob');
            $table->string('entry_point');
            $table->string('date_collected');
            $table->string('prophylaxis_code');
            $table->string('infant_feeding');
            $table->string('pcr');
            $table->string('alive_dead');
            $table->string('mother_age');
            $table->string('haart_date');
            $table->integer('processed');
            $table->integer('facility');
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
        Schema::dropIfExists('srl_eid');
    }
}
