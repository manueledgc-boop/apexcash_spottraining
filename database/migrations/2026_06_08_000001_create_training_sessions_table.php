<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('mode')->default('preflop');
            $table->string('module')->nullable();
            $table->unsignedInteger('total_spots')->default(0);
            $table->unsignedInteger('correct_spots')->default(0);
            $table->unsignedInteger('wrong_spots')->default(0);
            $table->decimal('accuracy', 5, 2)->default(0);
            $table->unsignedInteger('xp_earned')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'module']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
