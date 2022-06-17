<?php

use App\Models\Warehouse;
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
        Schema::table('article', function (Blueprint $table) {

            $table->foreignIdFor(Warehouse::class) // add foreign key for warehouse to existing 'article' table
                ->references("id")->on( (new Warehouse)->getTable() );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article', function (Blueprint $table) {
            // remove foreign key for warehouse to existing 'article' table
            $table->dropConstrainedForeignId(Warehouse::class);
        });
    }
};
