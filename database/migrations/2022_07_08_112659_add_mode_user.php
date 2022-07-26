<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->unsignedBigInteger('mode_id')->nullable();
            $table->foreign('mode_id')->references('id')->on('modes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users', function(Blueprint $table) {
            $table->dropForeign(['mode_id']);
            $table->dropColumn(['mode_id']);
        });
    }
}
