<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requisicao_produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisicao_id');
            $table->unsignedBigInteger('produto_id');
            $table->integer('quantidade')->default(1);
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('requisicao_id')->references('id')->on('requisicao')->cascadeOnDelete();
            $table->foreign('produto_id')->references('id')->on('produtos')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicao_produtos');
    }
};
