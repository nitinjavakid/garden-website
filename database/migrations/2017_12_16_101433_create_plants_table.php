<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->boolean("enabled")->default(true);
            $table->timestamp("last_watered")->nullable();
            $table->string("forward_pin");
            $table->string("reverse_pin");
            $table->string("adc_pin");
            $table->integer("device_id")->unsigned();
            $table->foreign("device_id")->references("id")->on("devices");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plants');
    }
}
