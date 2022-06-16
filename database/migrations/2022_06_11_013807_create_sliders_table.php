<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->integer('location')->default(0);
            $table->string('link_target',300)->default('#')->nullable();
            $table->string('image',300)->default('no-images.jpg')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('position')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};
