<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateMeasurementsTable
 */
class CreateMeasurementsTable extends Migration
{
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->increments('id');
            $table->float('value');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::drop('measurements');
    }
}
