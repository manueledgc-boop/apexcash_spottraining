<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            $table->timestamp('reviewed_at')->nullable()->after('analysis_status');
            $table->timestamp('user_seen_at')->nullable()->after('reviewed_at')->index();
            $table->string('review_reason')->nullable()->after('user_seen_at');
            $table->text('review_note')->nullable()->after('review_reason');
        });
    }

    public function down(): void
    {
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            $table->dropColumn(['reviewed_at', 'user_seen_at', 'review_reason', 'review_note']);
        });
    }
};
