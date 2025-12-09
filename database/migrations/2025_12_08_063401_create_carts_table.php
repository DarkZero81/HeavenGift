<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_cart_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // المفتاح الخارجي لربط العنصر بالعربة الرئيسية
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');

            // المفتاح الخارجي لربط العنصر بالمنتج
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2); // سعر المنتج وقت إضافته

            $table->timestamps();

            // التأكد من أن المنتج لا يتكرر في نفس العربة
            $table->unique(['cart_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
