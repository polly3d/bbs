<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->text('content_md');
            $table->integer('category_id')->unsign();
            $table->integer('user_id')->unsign();
            $table->integer('click_count')->unsign()->default(0);
            $table->integer('vote_count')->unsign()->default(0);
            $table->integer('comment_count')->unsign()->default(0);
            $table->enum('is_excellent',['yes','no'])->default('no');
            $table->softDeletes();
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
        Schema::drop('posts');
    }
}
