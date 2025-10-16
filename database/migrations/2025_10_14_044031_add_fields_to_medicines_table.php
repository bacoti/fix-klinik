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
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('type')->default('tablet')->after('name'); // tablet, capsule, syrup, injection, cream, ointment
            $table->string('unit', 50)->default('strip')->after('type'); // strip, bottle, tube, etc
            $table->decimal('price', 10, 2)->default(0)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn(['type', 'unit', 'price']);
        });
    }
};
