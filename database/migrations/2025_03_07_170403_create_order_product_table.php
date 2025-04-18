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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            // +++++++++++++++++++=
            // $table->integer('order_id')->unsigned()->nullable();
            // $table->foreign('order_id')->references('id')
                //   ->on('orders')->onUpdate('cascade')->onDelete('set null');

            // $table->integer('product_id')->unsigned()->nullable();
            // $table->foreign('product_id')->references('id')
                // ->on('products')->onUpdate('cascade')->onDelete('set null');
                $table->foreignId('order_id')->nullable()->constrained('orders')
                 ->onUpdate('cascade')->onDelete('cascade'); // استخدم cascade بدلًا من set null

              $table->foreignId('product_id')->nullable()->constrained('products')
                ->onUpdate('cascade')->onDelete('cascade');
               

            $table->integer('quantity')->unsigned();
            // ++++++++++++++++++++++++=
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
        Schema::dropIfExists('order_product');
    }
};
