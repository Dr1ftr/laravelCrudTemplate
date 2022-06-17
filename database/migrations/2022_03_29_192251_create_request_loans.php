<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Article;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_loan', function (Blueprint $table) { // table containing all request of loans of articles
            $table->id();

            $table->foreignIdFor(User::class)
                ->references('id')->on('users')
                    ->onDelete('NO ACTION');

            $table->foreignIdFor(Article::class)
                ->references('id')->on('article')
                    ->onDelete('NO ACTION');

            $table->integer('amount');
            $table->dateTime('loaning_start');
            $table->dateTime('loaning_end');
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
        Schema::dropIfExists('request_loan');
    }
};
