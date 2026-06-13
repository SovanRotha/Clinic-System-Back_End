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
        // Add register_id to appointment table
        if (Schema::hasTable('appointment') && !Schema::hasColumn('appointment', 'register_id')) {
            Schema::table('appointment', function (Blueprint $table) {
                $table->foreignId('register_id')->nullable()->constrained('register')->onDelete('cascade');
            });
        }

        // Add register_id to consultation table
        if (Schema::hasTable('consultation') && !Schema::hasColumn('consultation', 'register_id')) {
            Schema::table('consultation', function (Blueprint $table) {
                $table->foreignId('register_id')->nullable()->constrained('register')->onDelete('cascade');
            });
        }

        // Add register_id to prescription table
        if (Schema::hasTable('prescription') && !Schema::hasColumn('prescription', 'register_id')) {
            Schema::table('prescription', function (Blueprint $table) {
                $table->foreignId('register_id')->nullable()->constrained('register')->onDelete('cascade');
            });
        }

        // Add register_id and consultation_id to bills table
        if (Schema::hasTable('bills')) {
            if (!Schema::hasColumn('bills', 'register_id')) {
                Schema::table('bills', function (Blueprint $table) {
                    $table->foreignId('register_id')->nullable()->constrained('register')->onDelete('cascade');
                });
            }
            if (!Schema::hasColumn('bills', 'consultation_id')) {
                Schema::table('bills', function (Blueprint $table) {
                    $table->foreignId('consultation_id')->nullable()->constrained('consultation')->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop register_id from appointment
        if (Schema::hasTable('appointment') && Schema::hasColumn('appointment', 'register_id')) {
            Schema::table('appointment', function (Blueprint $table) {
                $table->dropForeignIdFor('register');
            });
        }

        // Drop register_id from consultation
        if (Schema::hasTable('consultation') && Schema::hasColumn('consultation', 'register_id')) {
            Schema::table('consultation', function (Blueprint $table) {
                $table->dropForeignIdFor('register');
            });
        }

        // Drop register_id from prescription
        if (Schema::hasTable('prescription') && Schema::hasColumn('prescription', 'register_id')) {
            Schema::table('prescription', function (Blueprint $table) {
                $table->dropForeignIdFor('register');
            });
        }

        // Drop register_id and consultation_id from bills
        if (Schema::hasTable('bills')) {
            if (Schema::hasColumn('bills', 'register_id')) {
                Schema::table('bills', function (Blueprint $table) {
                    $table->dropForeignIdFor('register');
                });
            }
            if (Schema::hasColumn('bills', 'consultation_id')) {
                Schema::table('bills', function (Blueprint $table) {
                    $table->dropForeignIdFor('consultation');
                });
            }
        }
    }
};
