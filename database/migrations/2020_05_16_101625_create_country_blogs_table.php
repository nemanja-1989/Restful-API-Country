<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("citizen_id")->unsigned();
            $table->foreign("citizen_id")->references("id")->on("citizens")->onDelete("cascade")->onUpdate("cascade");
            $table->string("name");
            $table->string("population");
            $table->string("area_code");
            $table->string("description", "1000");
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
        Schema::dropIfExists('country_blogs');
    }
}
