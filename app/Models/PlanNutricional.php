<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanNutricional extends Model
{
    //
    protected $fillable = [
        'name',
        'workspace_id',
        'fecha_inicio',
        'fecha_fin',
        'is_active'
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function recetas(): BelongsToMany
    {
        return $this->belongsToMany(Receta::class, 'plan_nutricional_recetas', 'plan_nutricional_id', 'receta_id')
            ->withPivot('semana', 'day', 'tipo_comida', 'notas', 'is_active')
            ->withTimestamps();
    }

}
