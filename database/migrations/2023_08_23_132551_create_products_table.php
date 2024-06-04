<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tabla = 'products';
    public function up(): void
    {
        Schema::create($this->tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')
                    ->nullable(false)
                    ->cascadeOnDelete();
            $table->string('name',60)->nullable(false);
            $table->string('slug',100)->unique()->nullable(false);
            $table->string('material',20)->unique()->nullable(false);
            $table->longtext('description')->nullable();
            $table->string('image',150)->nullable();
//            $table->unsignedBigInteger('quantity')->nullable(false); //Esto se puede poner en una tabla aparte que maneje inventarios por sitios
//            $table->decimal('price',10,2)->nullable(false);
            $table->boolean('is_visible')->default(false)->nullable(false);
            $table->boolean('is_featured')->default(false)->nullable(false);
            $table->enum('type',['deliverable','downloadable'])
                    ->default('deliverable')
                    ->nullable(false);
            $table->datetime('published_at')->nullable();
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
