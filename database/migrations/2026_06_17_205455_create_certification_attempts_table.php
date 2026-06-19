<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certification_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('attempt_number')->default(1);

            $table->unsignedInteger('total_questions')->default(75);
            $table->unsignedInteger('total_correct')->default(0);
            $table->unsignedInteger('total_wrong')->default(0);
            $table->decimal('global_score', 5, 2)->default(0);

            $table->unsignedInteger('preflop_total')->default(15);
            $table->unsignedInteger('preflop_correct')->default(0);
            $table->decimal('preflop_score', 5, 2)->default(0);

            $table->unsignedInteger('flop_total')->default(15);
            $table->unsignedInteger('flop_correct')->default(0);
            $table->decimal('flop_score', 5, 2)->default(0);

            $table->unsignedInteger('turn_total')->default(15);
            $table->unsignedInteger('turn_correct')->default(0);
            $table->decimal('turn_score', 5, 2)->default(0);

            $table->unsignedInteger('river_total')->default(15);
            $table->unsignedInteger('river_correct')->default(0);
            $table->decimal('river_score', 5, 2)->default(0);

            $table->unsignedInteger('mastery_total')->default(15);
            $table->unsignedInteger('mastery_correct')->default(0);
            $table->decimal('mastery_score', 5, 2)->default(0);

            $table->boolean('passed')->default(false);
            $table->boolean('distinction')->default(false);

            $table->string('result_label')->nullable();
            $table->string('certificate_code')->nullable()->unique();

            $table->json('questions_snapshot')->nullable();
            $table->json('answers_snapshot')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->timestamp('next_attempt_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'passed']);
            $table->index(['user_id', 'completed_at']);
            $table->index(['user_id', 'next_attempt_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certification_attempts');
    }
};