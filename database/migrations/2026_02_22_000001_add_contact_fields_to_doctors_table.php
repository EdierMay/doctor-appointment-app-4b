<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'address')) {
                $table->string('address')->nullable()->after('cedula');
            }
            if (!Schema::hasColumn('doctors', 'phone')) {
                $table->string('phone')->nullable()->after('address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            if (Schema::hasColumn('doctors', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('doctors', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
