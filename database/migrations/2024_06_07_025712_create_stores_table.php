<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private string $table = 'stores';
    public function up(): void {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('stores_group')->nullable(false);
            $table->string('store_code', 10)->unique()->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('location', 100)->nullable(true);
            $table->boolean('is_active')->default(1)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists($this->table);
    }
};
