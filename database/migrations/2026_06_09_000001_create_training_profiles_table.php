<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('training_profiles')->insert([
            [
                'code' => 'gto',
                'name' => 'GTO Teórico',
                'description' => 'Perfil base actual. Evalúa las respuestas usando la estrategia GTO simplificada de ApexCash.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'exploit_micro',
                'name' => 'Exploit Micro-límites',
                'description' => 'Reservado para futuro. Permitirá adaptar las respuestas a pools tipo NL2/NL5/NL10.',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('training_profiles');
    }
};
