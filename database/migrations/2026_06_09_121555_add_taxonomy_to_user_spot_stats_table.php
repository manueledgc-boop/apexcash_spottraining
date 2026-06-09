<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_spot_stats', function (Blueprint $table) {
            $table->string('family')->nullable()->after('module');
            $table->string('family_label')->nullable()->after('family');
            $table->string('concept')->nullable()->after('family_label');
            $table->string('concept_label')->nullable()->after('concept');

            $table->index(['user_id', 'family']);
            $table->index(['user_id', 'concept']);
        });
    }

    public function down(): void
    {
        Schema::table('user_spot_stats', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'family']);
            $table->dropIndex(['user_id', 'concept']);

            $table->dropColumn([
                'family',
                'family_label',
                'concept',
                'concept_label',
            ]);
        });
    }
};