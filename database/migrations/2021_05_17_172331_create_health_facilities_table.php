<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_facilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->text('name');
            $table->string('keph_level');
            $table->string('facility_type');
            $table->string('Sub_County_ID');
            $table->string('partner_id');
            $table->string('mobile');
            $table->timestamp('modified');
            $table->string('lat');
            $table->string('lng');
            $table->string('active');
            $table->string('active_last_month');
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
        Schema::dropIfExists('health_facilities');
    }
}
