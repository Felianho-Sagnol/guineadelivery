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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('phone');
            $table->string('town');
            $table->string('complementAddress')->nullable();
            $table->string('neighborhood')->nullable();
            $table->integer('isPopular')->default(0);
            $table->integer('minDeliveyFees')->default(0);
            $table->integer('isNew')->default(1);
            $table->integer('isOpen')->default(1);
            $table->integer('enabled')->default(1);
            $table->string('email')->nullable();
            $table->double('rating', 8, 2)->default(0);
            $table->double('discount')->default(0);
            $table->double('discountFrom')->default(0);
            $table->string('imageUrl')->nullable();
            $table->integer('minAmountToOrder')->default(0);
            $table->integer('cookMinTime')->default(10);
            $table->integer('cookMaxTime')->default(30);
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
        Schema::dropIfExists('restaurants');
    }
};
