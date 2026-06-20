<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            if (! Schema::hasColumn('hand_lab_spots', 'reviewed_by')) {
                $table->foreignId('reviewed_by')
                    ->nullable()
                    ->after('reviewed_at')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            if (Schema::hasColumn('hand_lab_spots', 'reviewed_by')) {
                $table->dropConstrainedForeignId('reviewed_by');
            }
        });
    }
};
