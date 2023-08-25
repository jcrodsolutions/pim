<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private string $tabla = 'categories';

    public function up(): void {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable(false);
            $table->string('slug')->unique()->nullable(false);
            $table->foreignId('parent_id')
                    ->nullable()
                    ->constrained(table: $this->tabla)
                    ->cascadeOnDelete();
            $table->boolean('is_visible')->default(false)->nullable(false);
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists($this->tabla);
    }
};
