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
        Schema::create('article', function (Blueprint $table) { // table containing all articles in the warehouse
            $table->id();

            // name of the article
            $table->string('name', 64)->index();

            // unsigned because it cannot be negative
            $table->integer('total_amount', false, true);

            // price of a single item (gets converted to and from float by eloquent's mutators/accessor)
            $table->integer('price')->comment('divide by 100 to get it\'s true value');
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
        Schema::dropIfExists('article');
    }
};
