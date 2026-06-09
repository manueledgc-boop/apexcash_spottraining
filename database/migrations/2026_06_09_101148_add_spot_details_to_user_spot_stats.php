<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_spot_stats', function (Blueprint $table) {

            $table->string('spot_title')
                ->nullable()
                ->after('module');

            $table->string('hero_cards', 20)
                ->nullable()
                ->after('spot_title');

        });
    }

    public function down(): void
    {
        Schema::table('user_spot_stats', function (Blueprint $table) {

            $table->dropColumn([
                'spot_title',
                'hero_cards',
            ]);

        });
    }
};