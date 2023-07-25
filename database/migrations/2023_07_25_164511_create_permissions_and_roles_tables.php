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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("label")->nullable();
            $table->timestamps();
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId("permission_id")->references("id")->on("permissions")->onDelete("cascade");
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");

            $table->primary(["permission_id", "user_id"]);
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("label")->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId("permission_id")->references("id")->on("permissions")->onDelete("cascade");
            $table->foreignId("role_id")->references("id")->on("roles")->onDelete("cascade");

            $table->primary(["permission_id", "role_id"]);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("role_id")->references("id")->on("roles")->onDelete("cascade");

            $table->primary(["user_id", "role_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');

        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
