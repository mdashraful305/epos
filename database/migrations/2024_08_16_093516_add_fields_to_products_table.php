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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'price')) {
                $table->decimal('price', 10, 2); // Product price
            }
            if (!Schema::hasColumn('products', 'original_price')) {
                $table->decimal('original_price', 10, 2)->nullable(); // Original price for comparison
            }
            if (!Schema::hasColumn('products', 'discounted_price')) {
                $table->decimal('discounted_price', 10, 2)->nullable(); // Discounted price
            }
            if (!Schema::hasColumn('products', 'stock')) {
                $table->integer('stock')->default(0); // Stock quantity
            }
            if (!Schema::hasColumn('products', 'sku')) {
                $table->string('sku')->unique(); // Stock Keeping Unit
            }
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('active'); // Status of the product
            }
            if (!Schema::hasColumn('products', 'subcategory_id')) {
                $table->unsignedBigInteger('subcategory_id')->nullable(); // Subcategory ID
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('products', 'original_price')) {
                $table->dropColumn('original_price');
            }
            if (Schema::hasColumn('products', 'discounted_price')) {
                $table->dropColumn('discounted_price');
            }
            if (Schema::hasColumn('products', 'stock')) {
                $table->dropColumn('stock');
            }
            if (Schema::hasColumn('products', 'sku')) {
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('products', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('products', 'subcategory_id')) {
                $table->dropForeign(['subcategory_id']);
                $table->dropColumn('subcategory_id');
            }
        });
    }
};
