<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSrlHtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srl_hts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sample_number');
            $table->string('client_name');
            $table->string('dob');
            $table->string('selected_sex');
            $table->string('telephone');
            $table->string('test_date');
            $table->string('selected_delivery_point');
            $table->string('selected_test_kit1');
            $table->string('lot_number1');
            $table->string('expiry_date1');
            $table->string('selected_test_kit2');
            $table->string('lot_number2');
            $table->string('expiry_date2');
            $table->string('selected_final_result');
            $table->string('sample_tester_name');
            $table->string('dbs_date');
            $table->string('dbs_dispatch_date');
            $table->string('requesting_provider');
            $table->integer('processed');
            $table->integer('facility');
            $table->integer('lab_id');
            $table->string('lab_name');
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
        Schema::dropIfExists('srl_hts');
    }
}
