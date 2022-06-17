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
        Schema::create('location', function (Blueprint $table) {
            $table->id();

            $table->string("name", 128)->nullable(true); // what the location is known as

            $table->string("country", 64);
            $table->string("city", 128);
            $table->string("street", 64);
            $table->integer("street_number");
            $table->string("street_number_addition", 16)->nullable(true);

            $table->string("postal_code", 16); // longest possible postal code is 10 characters

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
        Schema::dropIfExists('location');
    }
};
