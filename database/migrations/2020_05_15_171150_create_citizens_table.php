<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("country_id")->unsigned();
            $table->foreign("country_id")->references("id")->on("countries")->onDelete("cascade")->onUpdate("cascade");
            $table->string("name", "45");
            $table->string("email", "45");
            $table->string("password", "45");
            $table->tinyInteger("status")->unsigned();
            $table->string("image")->nullable();
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
        Schema::dropIfExists('citizens');
    }
}
