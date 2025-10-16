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
        Schema::table('examinations', function (Blueprint $table) {
            $table->text('anamnesis')->nullable()->after('doctor_id');
            $table->text('physical_examination')->nullable()->after('anamnesis');
            $table->text('additional_notes')->nullable()->after('prescription_text');
            $table->date('follow_up_date')->nullable()->after('sick_letter');
            $table->integer('sick_days')->nullable()->after('sick_letter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            $table->dropColumn([
                'anamnesis',
                'physical_examination',
                'additional_notes',
                'follow_up_date',
                'sick_days'
            ]);
        });
    }
};
