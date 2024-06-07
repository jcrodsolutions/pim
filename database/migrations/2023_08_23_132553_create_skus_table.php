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

            $table->string('material',20)->nullable(false);
            $table->string('sku',20)->nullable(false);
            $table->string('um',5)->nullable(false);
            $table->boolean('is_active')->default(true)->nullable(false);
            $table->timestamps();

            // Add the foreign key constraints
            $table->foreign('material')
                  ->references('material')
                  ->on('products')
                  ->cascadeOnDelete();
            $table->foreign('um')
                  ->references('um')
                  ->on('ums')
                  ->cascadeOnDelete();
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
