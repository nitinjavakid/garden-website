<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("secret");
            $table->boolean("enabled")->default(true);
            $table->timestamp("last_contacted")->nullable();
            $table->integer("garden_id")->unsigned();
            $table->foreign("garden_id")->references("id")->on("gardens");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
