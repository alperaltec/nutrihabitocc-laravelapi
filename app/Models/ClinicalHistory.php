<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClinicalHistory extends Model
{
    protected $fillable = [
        'content_data',
        'plantilla_formulario_id',
        'user_id',
        'workspace_id'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'content_data' => 'array',
        ];
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function plantilla(): BelongsTo
    {
        return $this->belongsTo(PlantillaFormulario::class, 'plantilla_formulario_id');
    }

}
