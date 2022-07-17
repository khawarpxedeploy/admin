<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->enum('type', ['pickup', 'delivery']);
            $table->enum('status', ['pending', 'accepted', 'delivered', 'cancelled']);
            $table->string('pickup_location')->nullable();
            $table->json('delivery_location')->nullable();
            $table->enum('payment_method', ['cash', 'card']);
            $table->boolean('payment_status')->default(0);
            $table->float('total')->default(0.00);
            $table->string('cancelled_reason')->nullable();
            $table->timestamp('delivered_on')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
