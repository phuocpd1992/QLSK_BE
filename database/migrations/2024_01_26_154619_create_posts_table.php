<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->text('typeOfField')->nullable();
            $table->text('category')->nullable();
            $table->text('motherCompany')->nullable();
            $table->text('company')->nullable();
            $table->text('title')->nullable();
            $table->text('subscription')->nullable();
            $table->text('content')->nullable();
            $table->text('userId')->nullable();
            $table->text('author1')->nullable();
            $table->text('author2')->nullable();
            $table->text('author3')->nullable();
            $table->text('author4')->nullable();
            $table->text('author5')->nullable();
            $table->text('author6')->nullable();
            $table->text('author7')->nullable();
            $table->text('author8')->nullable(); 
            $table->text('author9')->nullable();
            $table->text('author10')->nullable();
            $table->integer('status')->nullable();
            $table->integer('level')->nullable();
            $table->integer('view')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
