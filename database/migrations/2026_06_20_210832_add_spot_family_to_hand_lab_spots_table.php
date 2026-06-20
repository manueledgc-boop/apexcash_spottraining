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
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            $table->string('spot_family')->nullable()->after('spot_type');
            $table->string('spot_family_label')->nullable()->after('spot_family');
        });
    }

    public function down(): void
    {
        Schema::table('hand_lab_spots', function (Blueprint $table) {
            $table->dropColumn(['spot_family', 'spot_family_label']);
        });
    }
};
