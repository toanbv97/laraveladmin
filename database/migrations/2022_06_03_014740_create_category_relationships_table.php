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
        Schema::create('category_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->timestamps();
        });

        Schema::table('category_relationships', function (Blueprint $table) {
            $table->foreign('cat_id')->references('id')->on('categories');
            $table->foreign('post_id')->references('id')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::table('category_relationships', function (Blueprint $table) {
       //     $table->dropForeign('category_relationships_cat_id_foreign');
       //     $table->dropForeign('category_relationships_post_id_foreign');
       // });
        Schema::dropIfExists('category_relationships');
    }
};
