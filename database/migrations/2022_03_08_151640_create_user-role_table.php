<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user-role', function (Blueprint $table) { // N:N table connecting users to roles
            $table->id();

            $table->foreignIdFor(User::class)
                ->references('id')->on('users')
                    ->onDelete('cascade');

            $table->foreignIdFor(Role::class)
                ->references('id')->on('role')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('user-role');
    }
};
