<?php

use App\Models\Academy;
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
        Schema::table('users', function (Blueprint $table) {
            
            $table->foreignIdFor(Academy::class) // add foreign key for users to existing 'academy' table
                ->nullable(true) // 
                ->references("id")->on( (new Academy)->getTable() );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // remove foreign key for users to existing 'academy' table
            $table->dropConstrainedForeignId(Academy::class);
        });
    }
};
