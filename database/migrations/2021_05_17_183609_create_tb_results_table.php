<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_results', function (Blueprint $table) {
            $table->increments('tb_result_id');
            $table->string('sample_id');
            $table->string('kdod_number');
            $table->string('age');
            $table->string('gender');
            $table->string('test1');
            $table->string('result_value1');
            $table->string('test2');
            $table->string('result_value2');
            $table->string('test3');
            $table->string('result_value3');
            $table->string('mfl_code');
            $table->string('login_date');
            $table->string('date_reviewed');
            $table->string('record_date');
            $table->string('testing_lab');
            $table->string('processed');
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
        Schema::dropIfExists('tb_results');
    }
}
