<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_facilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Code');
            $table->string('Name');
            $table->string('OfficialName');
            $table->string('Registration_number');
            $table->string('Keph level');
            $table->string('Facility_type');
            $table->string('Facility_type_category');
            $table->string('Owner');
            $table->string('Owner_type');
            $table->string('Regulatory_body');
            $table->string('Beds');
            $table->string('Cots');
            $table->string('County');
            $table->string('Sub_county');
            $table->string('Ward');
            $table->string('Operation status');
            $table->string('Open_whole_day');
            $table->string('Open_public_holidays');
            $table->string('Open_weekends');
            $table->string('Open_late_night');
            $table->string('Service_names');
            $table->string('Approved');
            $table->string('Public visible');
            $table->string('Closed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_facilities');
    }
}
