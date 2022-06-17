<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Location;
use App\Models\Academy;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id();

            $table->string("name", 128); // how the warehouse is known
            $table->string("room", 128); // where the warehouse is located, usually the room number

            $table->foreignIdFor(Location::class)
                ->references("id")->on( (new Location)->getTable() )
                    ->onDelete("cascade"); // if a location is for example sold, all it's warehouses are deleted

            $table->foreignIdFor(Academy::class)
                ->references("id")->on( (new Academy)->getTable() );

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
        Schema::dropIfExists('warehouse');
    }
};
