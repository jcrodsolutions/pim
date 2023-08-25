<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'customers';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable(false);
            $table->string('email',200)->nullable(false);
            $table->string('phone',20)->nullable();
            $table->date('date_of_birth')->nullable(false);
            $table->string('address',150)->nullable();
            $table->string('zip_code',15)->nullable();
            //$table->foreignId('countryid')->constrained('country')->nullable(); // manejar aparte tabla de paises
            $table->string('city',20)->nullable();
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
