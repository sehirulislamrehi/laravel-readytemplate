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
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_active')->default(0);
            $table->string('lastActive')->nullable();
            $table->longText('access_token')->nullable()->default(null);
            $table->timestamps();
            
            // Role relation
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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