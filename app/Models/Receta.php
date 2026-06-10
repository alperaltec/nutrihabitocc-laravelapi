<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receta extends Model
{
    //
    protected $fillable = [
        'name',
        'is_active',
        'calorias',
        'informacion'
    ];

    protected $casts = [
        'informacion' => 'array',
        'is_active'   => 'boolean'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function planesNutricionales(): BelongsToMany
    {
        return $this->belongsToMany(PlanNutricional::class, 'plan_nutricional_recetas', 'receta_id', 'plan_nutricional_id')
            ->withPivot('id', 'semana', 'day', 'tipo_comida', 'notas', 'is_active')
            ->withTimestamps();
    }
}
