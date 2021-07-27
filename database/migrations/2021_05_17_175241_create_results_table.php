<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source');
            $table->string('result_id');
            $table->string('result_type');
            $table->string('request_id');
            $table->string('kdod_number');
            $table->string('age');
            $table->string('gender');
            $table->string('result_content');
            $table->string('units');
            $table->integer('data_key');
            $table->integer('mfl_code');
            $table->integer('lab_id');
            $table->string('cst');
            $table->string('cj');
            $table->string('csr');
            $table->string('date_collected');
            $table->string('lab_order_date');
            $table->integer('sys_code');
            $table->timestamp('date_sent');
            $table->timestamp('date_delivered');
            $table->timestamp('date_read');
            $table->integer('processed');
            $table->integer('il_send');
            $table->string('lab_name');
            $table->boolean('client_notified');
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
        Schema::dropIfExists('results');
    }
}
