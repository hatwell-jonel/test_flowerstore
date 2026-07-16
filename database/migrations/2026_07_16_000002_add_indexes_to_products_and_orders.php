<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('product_name');
            $table->index('price');
            $table->index('status');
            $table->index(['status', 'price']);
            $table->index(['status', 'product_name']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('price');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['product_name']);
            $table->dropIndex(['price']);
            $table->dropIndex(['status']);
            $table->dropIndex(['status', 'price']);
            $table->dropIndex(['status', 'product_name']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['price']);
            $table->dropIndex(['created_at']);
        });
    }
};
