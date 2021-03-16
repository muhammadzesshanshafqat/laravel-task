<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->primary('id');
            $table->unsignedBigInteger('post_id');
            $table->string('name', 40);
            $table->string('url', 80);
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts');
            $table->index(['post_id']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
