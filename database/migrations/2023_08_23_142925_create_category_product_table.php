<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'category_product';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->nullable(false);
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->nullable(false);
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
