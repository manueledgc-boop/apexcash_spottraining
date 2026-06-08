<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('training_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('spot_id')->nullable();
            $table->string('module');
            $table->string('module_label');
            $table->string('title');
            $table->string('hero_position', 8)->nullable();
            $table->string('villain_position', 8)->nullable();
            $table->json('hero_cards')->nullable();
            $table->string('selected_action', 20);
            $table->string('correct_action', 20);
            $table->string('grade', 20);
            $table->boolean('is_correct')->default(false);
            $table->unsignedSmallInteger('frequency')->nullable();
            $table->smallInteger('ev_score')->default(0);
            $table->unsignedSmallInteger('xp_earned')->default(0);
            $table->text('explanation')->nullable();
            $table->json('spot_snapshot')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'module']);
            $table->index(['user_id', 'grade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_results');
    }
};
