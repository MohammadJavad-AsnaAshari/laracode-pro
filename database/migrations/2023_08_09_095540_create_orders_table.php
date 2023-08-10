<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->bigInteger("price");
            $table->enum("status", ["unpaid", "paid", "preparation", "posted", "received", "canceled"]);
            $table->string("tracking_serial")->nullable();
            $table->timestamps();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignId("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->foreignId("product_id")->references("id")->on("products")->onDelete("cascade");

            $table->integer("quantity");

            $table->primary(["order_id", "product_id"]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
};
