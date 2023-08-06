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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("attribute_values", function (Blueprint $table) {
            $table->id();
            $table->foreignId("attribute_id")->references("id")->on("attributes")->onDelete("cascade");
            $table->string("value");
            $table->timestamps();
        });

        Schema::create("attribute_product", function (Blueprint $table) {
            $table->foreignId("attribute_id")->references("id")->on("attributes")->onDelete("cascade");
            $table->foreignId("product_id")->references("id")->on("products")->onDelete("cascade");

            $table->foreignId("value_id")->references("id")->on("attribute_values")->onDelete("cascade");

            $table->primary(["attribute_id", "product_id", "value_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_product');
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('attributes');
    }
};
