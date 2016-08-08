<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('settings_key', 64)->p;
            $table->string('value', 128);
            $table->primary('settings_key');
            $table->timestamps();
        });
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
