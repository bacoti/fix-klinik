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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->timestamp('dispensed_at')->nullable()->after('instructions');
            $table->foreignId('dispensed_by')->nullable()->constrained('users')->nullOnDelete()->after('dispensed_at');
            $table->dropColumn('dispensed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->boolean('dispensed')->default(false)->after('instructions');
            $table->dropConstrainedForeignId('dispensed_by');
            $table->dropColumn('dispensed_at');
        });
    }
};
