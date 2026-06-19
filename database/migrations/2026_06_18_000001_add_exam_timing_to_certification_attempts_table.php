<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certification_attempts', function (Blueprint $table) {
            if (! Schema::hasColumn('certification_attempts', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('started_at');
            }

            if (! Schema::hasColumn('certification_attempts', 'duration_seconds')) {
                $table->unsignedInteger('duration_seconds')->nullable()->after('completed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('certification_attempts', function (Blueprint $table) {
            if (Schema::hasColumn('certification_attempts', 'duration_seconds')) {
                $table->dropColumn('duration_seconds');
            }

            if (Schema::hasColumn('certification_attempts', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
        });
    }
};
