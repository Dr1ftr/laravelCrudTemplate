<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->string('name_product', 70);
            $table->string('name', 64); 
            $table->integer('total_amount', false, true); 
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
        Schema::dropIfExists('order');
    }
};
