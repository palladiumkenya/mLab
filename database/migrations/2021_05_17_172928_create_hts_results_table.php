<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHtsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hts_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nhrl_lab_id');
            $table->string('kdod_number');
            $table->string('age');
            $table->string('gender');
            $table->string('test');
            $table->string('result_value');
            $table->string('status');
            $table->string('component');
            $table->integer('mfl_code');
            $table->string('submit_date');
            $table->string('date_released');
            $table->integer('processed');
            $table->string('sample_id');
            $table->timestamp('date_sent');
            $table->timestamp('date_delivered');
            $table->timestamp('date_read');
            $table->integer('hts_result_id');
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
        Schema::dropIfExists('hts_results');
    }
}
