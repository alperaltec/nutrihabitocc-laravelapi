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
        Schema::create('plan_nutricionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->timestamps();
        });

        Schema::create('plan_nutricional_recetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_nutricional_id')->constrained('plan_nutricionals')->onDelete('cascade');
            $table->foreignId('receta_id')->constrained('recetas')->onDelete('cascade');

            $table->string('day');
            $table->string('tipo_comida');
            $table->text('notas')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_nutricional_recetas');
        Schema::dropIfExists('plan_nutricionals');
    }
};
