<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            // responsável pode ser nulo (apontará para users.id)
            $table->unsignedBigInteger('user_responsavel_id')->nullable();
            $table->timestamps();

            // criamos a FK para users aqui — users ainda existe sem setor_id
            $table->foreign('user_responsavel_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setores');
    }
};
