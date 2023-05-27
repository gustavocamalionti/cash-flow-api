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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->notNullable();
            $table->string('email', 255)->unique();
            $table->string('document', 14)->unique();
            $table->unsignedBigInteger('user_types_id');
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('password');
            $table->timestamps();

            $table->foreign('user_types_id')->references('id')->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
