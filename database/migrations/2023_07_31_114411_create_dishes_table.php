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
        Schema::create('dishes', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('restaurant_id');
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity')->default(1);
            $table->integer('available')->default(1);
            $table->integer('cookMinTime')->default(10);
            $table->string('description')->nullable();
            $table->double('rating', 8, 2)->default(0);
            $table->string('imageUrl');
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
        Schema::dropIfExists('dishes');
    }
};
