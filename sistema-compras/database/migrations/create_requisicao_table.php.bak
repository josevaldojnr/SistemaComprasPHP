<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requisicao', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requestor_id')->nullable();
            $table->unsignedBigInteger('pricing_id')->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->string('setor', 255); // se preferir usar setor_id, mude para unsignedBigInteger
            $table->unsignedInteger('status_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('requestor_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('pricing_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('buyer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('manager_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicao');
    }
};
