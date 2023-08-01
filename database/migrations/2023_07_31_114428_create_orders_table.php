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
        Schema::create('orders', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->bigInteger('restaurant_id');
            $table->bigInteger('user_id');
            $table->bigInteger('order_type_id');
            $table->bigInteger('payement_mode_id');
            $table->integer('total');
            $table->integer('amount');
            $table->integer('isPaid')->default(0);//0 non payé , 1 payé
            $table->integer('status')->default(1);//1=commande passée , 2 = valider , 3= affecter pour la livraison , 4 = encours de livraivon , 5=livrée 
            $table->integer('discount')->default(0);
            $table->integer('deliveryfees')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
