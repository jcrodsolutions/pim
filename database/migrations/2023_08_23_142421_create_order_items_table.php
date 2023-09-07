<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'order_items';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                    ->constrained('orders')
                    ->nullable(false)
                    ->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')
                    ->nullable(false)
                    ->cascadeOnDelete();
            $table->decimal('unit_price',10,2)->nullable(false);
            $table->unsignedBigInteger('quantity',10,4)->autoIncrement(false)->nullable(false);
            $table->decimal('tax',10,2)->default(0)->nullable(false);
            $table->decimal('total',10,2)->default(0)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tabla);
    }
};
