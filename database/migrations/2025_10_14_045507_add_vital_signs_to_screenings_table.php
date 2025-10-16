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
        Schema::table('screenings', function (Blueprint $table) {
            $table->integer('blood_pressure_systolic')->nullable()->after('temperature');
            $table->integer('blood_pressure_diastolic')->nullable()->after('blood_pressure_systolic');
            $table->integer('heart_rate')->nullable()->after('blood_pressure_diastolic');
            $table->integer('respiratory_rate')->nullable()->after('heart_rate');
            $table->integer('oxygen_saturation')->nullable()->after('respiratory_rate');
            $table->text('notes')->nullable()->after('complaints');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropColumn([
                'blood_pressure_systolic',
                'blood_pressure_diastolic',
                'heart_rate',
                'respiratory_rate',
                'oxygen_saturation',
                'notes'
            ]);
        });
    }
};
