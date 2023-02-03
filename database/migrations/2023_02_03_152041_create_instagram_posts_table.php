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
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('profileId');
            $table->bigInteger('instagramId');
            $table->text('imageUrl');
            $table->text('caption');
            $table->bigInteger('commentCount');
            $table->bigInteger('likedCount');
        });
        Schema::table('instagram_posts', function (Blueprint $table) {
            $table->foreign('profileId')->references('id')->on('instagram_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instagram_posts');
    }
};
