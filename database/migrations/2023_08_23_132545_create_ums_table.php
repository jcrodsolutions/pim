<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'ums';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->string('um',5)->unique()->nullable(false);
            $table->string('description',50)->nullable(false);
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
