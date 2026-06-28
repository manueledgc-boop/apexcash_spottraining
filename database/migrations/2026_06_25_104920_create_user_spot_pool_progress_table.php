<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_spot_pool_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('stage', 30);
            $table->string('pool_key', 120);
            $table->string('spot_id', 160);
            $table->unsignedInteger('cycle')->default(1);
            $table->timestamp('seen_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'pool_key', 'spot_id', 'cycle'], 'user_pool_spot_cycle_unique');
            $table->index(['user_id', 'pool_key', 'cycle'], 'user_pool_cycle_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_spot_pool_progress');
    }
};