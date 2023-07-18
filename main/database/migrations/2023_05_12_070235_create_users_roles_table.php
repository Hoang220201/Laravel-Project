<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->increments('id');
    
         //FOREIGN KEY
           $table->foreignUuid('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

        });
    }
    
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
    
};
