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
        Schema::table('prescription', function (Blueprint $table) {
            //
            $table->foreignId('register_id')->nullable()->constrained('register')->onDelete('set null')->after('consultation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription', function (Blueprint $table) {
            //
            $table->dropForeign('prescription_register_id_foreign');
            $table->dropColumn('register_id');
        });
    }
};
