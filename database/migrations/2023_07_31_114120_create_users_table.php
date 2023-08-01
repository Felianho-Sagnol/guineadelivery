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
        Schema::create('users', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phone');
            $table->string('address');
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('token')->nullable();
            $table->string('imageUrl')->nullable();
            $table->integer('loyaltyPpoints')->default(0);
            $table->integer('walletBalance')->default(0);
            $table->timestamp('created_at')->useCurrent();
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
};
