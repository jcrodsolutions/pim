<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'orders';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->nullable(false)->cascadeOnDelete();
            $table->string('order',50)->unique()->nullable(false);
            $table->decimal('total_price',10,2)->default(0)->nullable(false); // jcr: maybe not needed ..maybe for totals control vs detail
            $table->enum('status',['pending','processing','completed','declined'])
                    ->default('pending')
                    ->nullable(false);
            $table->decimal('shipping_price',10,2)->default(0)->nullable(false);
            $table->longText('notes')->nullable();
            $table->softDeletes();
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
