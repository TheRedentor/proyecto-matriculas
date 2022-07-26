<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPlateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_plate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->foreign('list_id')->references('id')->on('lists')->onDelete('cascade');
            $table->unsignedBigInteger('plate_id');
            $table->foreign('plate_id')->references('id')->on('plates')->onDelete('cascade');
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
        Schema::dropIfExists('list_plate', function (Blueprint $table) {
            $table->dropForeign(['list_id']);
            $table->dropColumn(['list_id']);
            $table->dropForeign(['plate_id']);
            $table->dropColumn(['plate_id']);
        });
    }
}
