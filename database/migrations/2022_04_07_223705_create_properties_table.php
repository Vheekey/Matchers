<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->longText('address');
            $table->string('propertyType');
            $table->integer('area');
            $table->integer('yearOfConstruction');
            $table->integer('rooms');
            $table->string('heatingType');
            $table->boolean('parking');
            $table->bigInteger('returnActual');
            $table->bigInteger('price');
            $table->bigInteger('returnPotential');
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
        Schema::dropIfExists('properties');
    }
};
