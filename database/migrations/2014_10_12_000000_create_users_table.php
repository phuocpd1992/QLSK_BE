<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('levelOfAdmin')->nullable();
            $table->text('gender')->nullable();
            $table->text('birthday')->nullable();
            $table->text('mobile')->nullable();
            $table->text('certificate')->nullable();
            $table->text('motherCompany')->nullable();
            $table->text('company')->nullable();
            $table->text('department')->nullable();
            $table->text('position')->nullable();
            $table->text('thumbnailUrl')->nullable();
            $table->text('role')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
