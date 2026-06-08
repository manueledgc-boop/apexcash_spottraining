<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_training_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('module')->default('global');
            $table->string('module_label')->default('Global');
            $table->unsignedInteger('total_spots')->default(0);
            $table->unsignedInteger('correct_spots')->default(0);
            $table->unsignedInteger('wrong_spots')->default(0);
            $table->unsignedInteger('best')->default(0);
            $table->unsignedInteger('good')->default(0);
            $table->unsignedInteger('marginal')->default(0);
            $table->unsignedInteger('mistake')->default(0);
            $table->unsignedInteger('blunder')->default(0);
            $table->decimal('accuracy', 5, 2)->default(0);
            $table->unsignedInteger('xp')->default(0);
            $table->unsignedInteger('level')->default(1);
            $table->timestamps();

            $table->unique(['user_id', 'module']);
            $table->index(['user_id', 'accuracy']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_training_stats');
    }
};
