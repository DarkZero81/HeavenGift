<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cartitems', function (Blueprint $table) {
            if (!Schema::hasColumn('cartitems', 'cart_id')) {
                $table->foreignId('cart_id')->nullable()->constrained('carts')->nullOnDelete();
            }
            if (!Schema::hasColumn('cartitems', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            }
            if (!Schema::hasColumn('cartitems', 'quantity')) {
                $table->integer('quantity')->default(1);
            }
            if (!Schema::hasColumn('cartitems', 'price')) {
                $table->decimal('price', 10, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('cartitems', function (Blueprint $table) {
            foreach (['cart_id','product_id','quantity','price'] as $col) {
                if (Schema::hasColumn('cartitems', $col)) {
                    // dropping foreign keys safely
                    if (in_array($col, ['cart_id','product_id'])) {
                        $table->dropForeign([$col]);
                    }
                    $table->dropColumn($col);
                }
            }
        });
    }
};
