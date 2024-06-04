<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'skus';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')
                    ->nullable(false)
                    ->cascadeOnDelete();
            $table->string('sku',20)->nullable(false);
            $table->boolean('is_active')->default(true)->nullable(false);
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
