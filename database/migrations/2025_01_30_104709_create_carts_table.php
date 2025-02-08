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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('size')->nullable(); // Tailles facultatives
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Clé étrangère vers les produits
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // Clé étrangère vers les utilisateurs
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
