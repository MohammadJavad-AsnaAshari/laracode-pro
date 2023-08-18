<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("percent");
            $table->string("user")->nullable();

            $table->timestamp("expired_at");
            $table->timestamps();
        });

        Schema::create("discount_product", function (Blueprint $table) {
            $table->foreignId("discount_id")->references("id")->on("discounts")->onDelete("cascade");
            $table->foreignId("product_id")->references("id")->on("products")->onDelete("cascade");

            $table->primary(["discount_id", "product_id"]);
        });

        Schema::create("category_discount", function (Blueprint $table) {
            $table->foreignId("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreignId("discount_id")->references("id")->on("discounts")->onDelete("cascade");

            $table->primary(["discount_id", "category_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_product');
        Schema::dropIfExists('category_discount');
        Schema::dropIfExists('discounts');
    }
};
