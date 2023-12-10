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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->foreignId('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
            $table->integer('quantity');
            $table->foreignId('cart_id')
            ->references('id')
            ->on('carts')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
