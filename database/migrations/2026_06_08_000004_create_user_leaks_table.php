<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_leaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module');
            $table->string('module_label');
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('correct')->default(0);
            $table->decimal('accuracy', 5, 2)->default(0);
            $table->unsignedInteger('mistakes')->default(0);
            $table->unsignedInteger('blunders')->default(0);
            $table->decimal('weakness_score', 8, 2)->default(0);
            $table->timestamp('last_mistake_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'module']);
            $table->index(['user_id', 'weakness_score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_leaks');
    }
};
