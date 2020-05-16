<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMountainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mountains', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("country_blog_id")->unsigned();
            $table->foreign("country_blog_id")->references("id")->on("country_blogs")->onDelete("cascade")->onUpdate("cascade");
            $table->string("name");
            $table->string("description", "1000");
            $table->string("elevation");
            $table->string("promience");
            $table->string("coordination");
            $table->string("isolation");
            $table->string("image1")->nullable();
            $table->string("image2")->nullable();
            $table->string("image3")->nullable();
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
        Schema::dropIfExists('mountains');
    }
}
