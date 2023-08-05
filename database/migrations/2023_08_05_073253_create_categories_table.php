<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("parent_id");
            $table->timestamps();
        });

        Schema::create("category_product", function (Blueprint $table) {
            $table->foreignId("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreignId("product_id")->references("id")->on("products")->onDelete("cascade");

            $table->primary(["category_id", "product_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('categories');
    }
};
