<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_spot_stats', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('spot_id', 100);

            $table->string('module', 100);

            $table->unsignedInteger('total')
                ->default(0);

            $table->unsignedInteger('correct')
                ->default(0);

            $table->unsignedInteger('wrong')
                ->default(0);

            $table->decimal('accuracy', 5, 2)
                ->default(0);

            $table->timestamp('last_seen_at')
                ->nullable();

            $table->timestamp('last_wrong_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'user_id',
                'spot_id'
            ]);

            $table->index([
                'user_id',
                'module'
            ]);

            $table->index([
                'user_id',
                'accuracy'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_spot_stats');
    }
};