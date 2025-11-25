<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'setor_id')) {
                $table->unsignedBigInteger('setor_id')->nullable()->after('role_id');
                $table->foreign('setor_id')->references('id')->on('setores')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'setor_id')) {
                $table->dropForeign(['setor_id']);
                $table->dropColumn('setor_id');
            }
        });
    }
};
