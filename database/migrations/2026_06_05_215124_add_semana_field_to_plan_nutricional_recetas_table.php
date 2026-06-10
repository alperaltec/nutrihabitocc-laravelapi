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
        Schema::table('plan_nutricional_recetas', function (Blueprint $table) {
            $table->integer('semana')->default(1)->after('receta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_nutricional_recetas', function (Blueprint $table) {
            $table->dropColumn('semana');
        });
    }
};
