<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->decimal('preco', 10, 2);
            $table->unsignedBigInteger('categoria_id');
            $table->softDeletes(); // deleted_at
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
