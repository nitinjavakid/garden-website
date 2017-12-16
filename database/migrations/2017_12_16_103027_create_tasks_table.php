<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->enum("type", ["water"]);
            $table->boolean("enabled")->default(true);
            $table->timestamp("last_run")->nullable();
            $table->integer("time_interval");
            $table->json("data")->nullable();
            $table->json("rules")->nullable();
            $table->integer("plant_id")->unsigned();
            $table->foreign("plant_id")->references("id")->on("plants");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
