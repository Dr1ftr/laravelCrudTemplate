<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Loan;
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
        Schema::create('loan-article', function (Blueprint $table) { // N:N table connecting requestloan to article
            $table->id();

            $table->foreignIdFor(Loan::class)
                ->references('id')->on('loan')
                    ->onDelete('NO ACTION');

            $table->foreignIdFor(Article::class)
                ->references('id')->on('article')
                    ->onDelete('NO ACTION');

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
        Schema::dropIfExists('loan-article');
    }
};
