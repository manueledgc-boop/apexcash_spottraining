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
       Schema::create('founder_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('country')->nullable();
            $table->string('poker_experience')->nullable();
            $table->string('main_format')->nullable();
            $table->string('usual_level')->nullable();

            $table->text('motivation');
            $table->text('expectations')->nullable();

            $table->boolean('willing_to_give_feedback')->default(false);

            $table->string('status')->default('pending'); 
            // pending, approved, rejected

            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('founder_applications');
    }
};
