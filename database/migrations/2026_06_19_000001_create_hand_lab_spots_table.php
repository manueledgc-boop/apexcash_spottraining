<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hand_lab_spots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('format')->default('cash');
            $table->string('street', 20)->index();
            $table->string('spot_type')->nullable()->index();
            $table->string('normalized_signature')->nullable()->index();

            $table->string('hero_position', 10)->nullable()->index();
            $table->string('villain_position', 10)->nullable()->index();

            $table->json('hero_cards')->nullable();
            $table->json('board_cards')->nullable();
            $table->decimal('pot_bb', 8, 2)->default(0);
            $table->decimal('spr', 8, 2)->nullable();
            $table->decimal('effective_stack_bb', 8, 2)->default(0);

            $table->json('action_history')->nullable();
            $table->json('active_players')->nullable();
            $table->json('options')->nullable();

            $table->string('selected_action')->nullable();
            $table->string('best_action')->nullable();
            $table->text('gto_explanation')->nullable();
            $table->text('exploit_explanation')->nullable();
            $table->json('concepts')->nullable();
            $table->string('leak_label')->nullable();

            $table->string('source_type')->default('user_lab')->index();
            $table->string('visibility')->default('private')->index();
            $table->string('review_status')->default('private')->index();
            $table->string('analysis_status')->default('pending')->index();

            $table->foreignId('matched_spot_id')->nullable()->constrained('hand_lab_spots')->nullOnDelete();
            $table->boolean('used_ai')->default(false);
            $table->string('analysis_version')->nullable();
            $table->json('raw_payload')->nullable();

            $table->timestamps();

            $table->index(['review_status', 'visibility']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hand_lab_spots');
    }
};
